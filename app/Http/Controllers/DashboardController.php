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

    // 1. تحديد الوقت والطقس
    $hour = (int) now()->format('H');
    $isDay = ($hour >= 6 && $hour <= 20);
    $cloudiness = rand(0, 100);

    // 2. حساب الإنتاج
    $production = 0;
    if ($userPanelsCount > 0 && $isDay) {
        $baseProd = rand(200, 450) * $userPanelsCount;
        $production = $baseProd * (1 - ($cloudiness / 100));
    }

    // 3. المنطق ديال التنبيه (يخلق التنبيه فقط إذا كان الإنتاج 0 والمستخدم عندو ألواح)
    if ($userPanelsCount > 0 && $production == 0) {
        $existingNotification = Notification::where('user_id', $userId)
            ->where('message', 'الإنتاج متوقف! تأكد من الألواح.')
            ->where('created_at', '>=', now()->subMinutes(10))
            ->first();

        if (!$existingNotification) {
            Notification::create([
                'user_id' => $userId,
                'message' => 'الإنتاج متوقف! تأكد من الألواح.',
            ]);
        }
    }

    // 4. الحساب ديال الاستهلاك (يرجع 0 إذا كان المستخدم معندوش ألواح)
    $consumption = ($userPanelsCount > 0) ? rand(50, 300) : 0;

    return response()->json([
        'production' => round($production),
        'consumption' => $consumption,
        'timestamp' => now()->format('H:i'),
        'isDay' => $isDay,
        'cloudiness' => $cloudiness
    ]);
}

}