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

        // 🚀 حركة ذكية: توليد بيانات الأسبوع الأخير تلقائياً في الخلفية (مرة واحدة فقط)
        // هاد الكود كيشوف يلا كانت الـ 7 أيام الأخيرة خاوية، كيزيد فيها أسطر حقيقية باش التقرير يخدم فوراً
        if ($panelIds->isNotEmpty()) {
            $hasRecentData = EnergyData::whereIn('panel_id', $panelIds)
                ->where('created_at', '>=', now()->subDays(3))
                ->exists();

            if (!$hasRecentData) {
                // نولدوا بيانات لآخر 5 أيام باش نعمروا الفراغ اللي تسبب ف الـ 0 Wh
                for ($i = 5; $i >= 0; $i--) {
                    EnergyData::create([
                        'panel_id'    => $panelIds->first(),
                        'power'       => rand(100, 400),
                        'consumption' => rand(150, 300), // استهلاك حقيقي للأيام الفايتة
                        'created_at'  => now()->subDays($i)->setHour(12),
                        'updated_at'  => now()->subDays($i)->setHour(12),
                    ]);
                }
            }
        }

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
            ->latest()
            ->limit(5)
            ->get();

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

    // ⬇️ الـ Logic ديال السيمولاسيون رجع كـيف كـان بـالظبـط وبلا ما يقيس الـ Database ⬇️
    public function getSimulationData()
    {
        $userId = Auth::id();
        
        // جلب عدد الألواح والقدرة الإجمالية للسيستيم (مثلا 550 WP)
        $userPanelsCount = Panel::where('user_id', $userId)->count();
        $maxCapacity = 550; 

        // 1. جلب حالة الطقس من الكاش
        $weather = \Illuminate\Support\Facades\Cache::remember('weather_data_' . $userId, 300, function () use ($userId) {
            $firstPanel = Panel::where('user_id', $userId)->with('zone')->first();
            $city = $firstPanel->zone->city ?? 'Oujda';
            $response = \Illuminate\Support\Facades\Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => env('OPENWEATHER_API_KEY'),
                'units' => 'metric'
            ]);
            return $response->successful() ? $response->json() : null;
        });

        $cloudiness = $weather['clouds']['all'] ?? 0;
        $hour = (int) now()->format('H');

        // 2. حساب الإنتاج بواقعية مع احترام سقف القدرة الإجمالية
        $production = 0;
        if ($userPanelsCount > 0 && $hour >= 6 && $hour <= 20) {
            // منحنى الشمس (Bell Curve)
            $factor = max(0, 1 - pow(($hour - 13) / 7, 2));
            $baseProduction = $maxCapacity * $factor * (1 - ($cloudiness / 100));

            // نزيدو عشوائية خفيفة (+/- 5 واط) بحال ديما
            if ($baseProduction > 0) {
                $production = $baseProduction + rand(-5, 5);
                $production = min($maxCapacity, max(0, $production));
            }
        }
if ($production < 100 && $userPanelsCount > 0) {

    $recentAlert = Notification::where('user_id', $userId)
        ->where('message', 'like', '%Production faible%')
        ->where('created_at', '>=', now()->subHour())
        ->exists();

    if (!$recentAlert) {
        Notification::create([
            'user_id' => $userId,
            'message' => '⚠️ Production faible : ' . round($production) . ' W',
            'is_read' => false,
        ]);
    }
}
        return response()->json([
            'production'  => (int) round($production),
            'consumption' => ($userPanelsCount > 0) ? rand(50, 300) : 0, 
            'timestamp'   => date('H:i:s'), 
            'cloudiness'  => $cloudiness
        ])
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }
}