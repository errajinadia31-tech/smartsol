<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\EnergyData;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. جلب ألواح المستخدم الحالي
        $panels = Panel::where('user_id', $userId)->get();
        $panelIds = $panels->pluck('id');

        // 2. الحسابات الإحصائية للكوارط العليا
        $totalPanels = $panels->count();
        $activePanelsCount = $panels->where('status', 'active')->count();
        $maintenanceCount = $panels->where('status', 'maintenance')->count();
        $totalPower = $panels->sum('power_capacity');

        // 3. جلب آخر قراءات حية (Live Data) لكل لوحة وجمعها
        $latestReadingsPerPanel = EnergyData::whereIn('panel_id', $panelIds)
            ->latest('created_at')
            ->get()
            ->unique('panel_id');

        $currentProduction = $latestReadingsPerPanel->sum('power');
        $currentConsommation = $latestReadingsPerPanel->sum('consumption');

        // 4. الداتا ديال الـ Chart (آخر 13 تسجيل مجمعين على حساب الوقت)
        $latestReadings = EnergyData::whereIn('panel_id', $panelIds)
            ->latest('created_at')
            ->take(13)
            ->get()
            ->reverse(); // ترتيب من الأقدم للأحدث ف المبيان

        $chartConsumption = $latestReadings->pluck('consumption');

        $notifications = Notification::where('user_id', Auth::id())

        ->latest()->limit(5)->get();
        return view('dashboard', compact(
            'totalPanels', 
            'activePanelsCount', 
            'maintenanceCount', 
            'totalPower', 
            'currentProduction', 
            'currentConsommation', 
            'latestReadings', 
            'chartConsumption', 
            'notifications'
        ));
    }

public function getSimulationData()
{
    $userId = Auth::id();
    $userPanelsCount = Panel::where('user_id', $userId)->count();

    // 1. جلب حالة الطقس من الكاش (باش نسرعوا الـ Dashboard ونحميوا الـ API Key)
    $weather = \Illuminate\Support\Facades\Cache::remember('weather_data_' . $userId, 300, function () use ($userId) {
        $city = Panel::where('user_id', $userId)->with('zone')->first()->zone->city ?? 'Oujda';
        $response = \Illuminate\Support\Facades\Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
            'units' => 'metric'
        ]);
        return $response->successful() ? $response->json() : null;
    });

    $cloudiness = $weather['clouds']['all'] ?? 0;
    $hour = (int) now()->format('H');

    // 2. حساب الإنتاج بواقعية
    $production = 0;
    if ($userPanelsCount > 0 && $hour >= 6 && $hour <= 20) {
        // منحنى الشمس (Bell Curve)
        $factor = max(0, 1 - pow(($hour - 13) / 7, 2));
        // تأثير الغيوم الحقيقي: كلما زادت الغيوم (cloudiness)، نقص الإنتاج
        $production = 450 * $userPanelsCount * $factor * (1 - ($cloudiness / 100));
    }

    return response()->json([
        'production'  => round($production),
        'consumption' => ($userPanelsCount > 0) ? rand(50, 300) : 0,
        'timestamp'   => now()->format('H:i'),
        'cloudiness'  => $cloudiness
    ]);
}
}