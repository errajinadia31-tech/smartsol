<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\EnergyData;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\LowProductionSmsNotification;
use App\Notifications\ProductionAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

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

    
        if ($panelIds->isNotEmpty()) {
            $hasRecentData = EnergyData::whereIn('panel_id', $panelIds)
                ->where('created_at', '>=', now()->subDays(3))
                ->exists();

            if (!$hasRecentData) {
                foreach ($panelIds as $panelId) {
    for ($i = 5; $i >= 0; $i--) {
        EnergyData::create([
            'panel_id'    => $panelId,
            'power'       => rand(100, 400),
            'voltage'     => rand(200, 250),
            'current'     => rand(1, 5),
            'energy_kwh'  => rand(1, 10) / 10,
            'consumption' => rand(150, 300),
            'created_at'  => now()->subDays($i)->setHour(12),
            'updated_at'  => now()->subDays($i)->setHour(12),
        ]);
    }
}
        }

        // 3. جلب آخر قراءات حية (Live Data) لكل لوحة وجمعها
        $latestReadingsPerPanel = EnergyData::whereIn('panel_id', $panelIds)
    ->orderBy('created_at', 'desc')
    ->get()
    ->groupBy('panel_id')
    ->map->first();

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

  // 🌤️ WEATHER PART
    $apiKey = env('OPENWEATHER_API_KEY');

    $cities = $panels->map(fn($p) => $p->zone->city ?? null)
        ->filter()
        ->unique();

    $weatherCards = [];

    foreach ($cities as $city) {

        $weatherCards[$city] = Cache::remember("weather_$city", 3600, function () use ($city, $apiKey) {

            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'fr'
            ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            return [
                'city' => $city,
                'temp' => round($data['main']['temp']),
                'humidity' => $data['main']['humidity'] ?? 0,
                'wind' => round($data['wind']['speed'] ?? 0),
                'icon' => $data['weather'][0]['icon'] ?? null,
                'desc' => $data['weather'][0]['description'] ?? null,
            ];
        });
    }


        return view('dashboard', compact(
            'totalPanels', 
            'activePanelsCount', 
            'maintenanceCount', 
            'totalPower', 
            'currentProduction', 
            'currentConsommation', 
            'latestReadings', 
            'chartConsumption', 
            'notifications',
            'weatherCards'
        ));
    }


    } 
public function getSimulationData()
{
    $user = Auth::user();
    $userId = $user->id;

    $panel = Panel::where('user_id', $userId)->first();

    if (!$panel) {
        return response()->json([
            'error' => 'No panel found'
        ], 404);
    }

    $userPanelsCount = Panel::where('user_id', $userId)->count();

    $maxCapacity = 550;

    $weather = Cache::remember(
        'weather_data_' . $userId,
        300,
        function () use ($panel) {

            $city = $panel->zone->city ?? 'Oujda';

            $response = Http::get(
                'https://api.openweathermap.org/data/2.5/weather',
                [
                    'q' => $city,
                    'appid' => env('OPENWEATHER_API_KEY'),
                    'units' => 'metric'
                ]
            );

            return $response->successful()
                ? $response->json()
                : null;
        }
    );

    $cloudiness = $weather['clouds']['all'] ?? 0;
    $hour = (int) now()->format('H');

    $production = 0;

    if ($hour >= 6 && $hour <= 20) {

        $factor = max(0, 1 - pow(($hour - 13) / 7, 2));

        $baseProduction =
            $maxCapacity *
            $factor *
            (1 - ($cloudiness / 100));

        if ($baseProduction > 0) {
            $production = $baseProduction + rand(-5, 5);
            $production = min(
                $maxCapacity,
                max(0, $production)
            );
        }
    }

    $prodRounded = (int) round($production);
    $consumption = rand(50, 300);

    EnergyData::create([
        'panel_id' => $panel->id,
        'power' => $prodRounded,
        'consumption' => $consumption,
        'voltage' => rand(220, 240),
        'current' => rand(2, 8),
        'energy_kwh' => round($prodRounded / 1000, 4),
    ]);

    // =========================
    // ALERT LOW PRODUCTION
    // =========================

    if ($production < 100 && $userPanelsCount > 0) {

        $recentAlert = Notification::where('user_id', $userId)
            ->where('message', 'like', '%انخفاض%')
            ->where('created_at', '>=', now()->subHour())
            ->exists();

        if (!$recentAlert) {

            Notification::create([
                'user_id' => $userId,
                'message' => '⚠️ انخفاض في الإنتاج: ' . $prodRounded . ' واط',
                'is_read' => false,
            ]);

            if ($user->email) {

                Mail::raw(
                    "مرحباً {$user->name}

⚠️ تم اكتشاف انخفاض في إنتاج الطاقة.

الإنتاج الحالي: {$prodRounded} واط
الحد الأدنى: 100 واط

يرجى التحقق من الألواح الشمسية الخاصة بك.

فريق SmartSol",
                    function ($message) use ($user) {

                        $message->to($user->email)
                            ->subject('⚠️ تنبيه SmartSol - انخفاض الإنتاج');
                    }
                );
            }

            // SMS
            if (!empty($user->phone)) {
                $user->notify(
                    new LowProductionSmsNotification($prodRounded)
                );
            }
        }
    }

    return response()->json([
        'production' => $prodRounded,
        'consumption' => $consumption,
        'timestamp' => now()->format('H:i:s'),
        'cloudiness' => $cloudiness,
    ])->header(
        'Cache-Control',
        'no-store, no-cache, must-revalidate, max-age=0'
    );
}
}