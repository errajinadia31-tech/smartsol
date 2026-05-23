<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\Zone;
use App\Models\EnergyData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PanelController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $zones = Zone::all();
        $panels = Panel::where('user_id', $userId)->with('zone')->latest()->get();

        $weatherData = [];
        $apiKey = env('OPENWEATHER_API_KEY');

        // جلب المدن الفريدة فقط
        $cities = $panels->pluck('zone.city')->unique()->filter();

        foreach ($cities as $city) {
            try {
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                    'q' => $city,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'fr'
                ]);

                if ($response->successful()) {
                    $weatherData[$city] = $response->json();
                }
            } catch (\Exception $e) { continue; }
        }

        return view('panels.panel', compact('panels', 'zones', 'weatherData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'serial_number'  => 'required|string|unique:panels,serial_number',
            'power_capacity' => 'required|numeric|min:0',
            'status'         => 'required|in:active,inactive,maintenance',
            'zone_id'        => 'required|exists:zones,id',
        ]);

        // 1️⃣ تسجيل اللوحة الجديدة ف الـ Database وربطها بالـ User الحالي
        $panel = Panel::create([
            'name'           => $request->name,
            'serial_number'  => $request->serial_number,
            'power_capacity' => $request->power_capacity,
            'status'         => $request->status,
            'user_id'        => Auth::id(), 
            'zone_id'        => $request->zone_id,
        ]);

        // 2️⃣ الـ Logic الجديد: توليد داتا تلقائية فورية لهاد اللوحة (آخر ساعتين)
        for ($i = 12; $i >= 0; $i--) {
            $time = Carbon::now()->subMinutes($i * 10);
            $basePower = $panel->power_capacity;
            $hour = $time->hour;

            // حساب الإنتاج والاستهلاك على حساب الوقت (ليل / نهار)
            if ($hour >= 7 && $hour <= 18) {
                // ☀️ النهار: الإنتاج طالع والاستهلاك كيمثل 60% تقريباً
                $variation = rand(55, 95) / 100;
                $power = round($basePower * $variation, 2);
                $consumption = round(($power * 0.6) + rand(5, 15), 2);
            } else {
                // 🌙 الليل: الإنتاج منعدم، والاستهلاك منزلي عادي
                $variation = rand(0, 5) / 100;
                $power = round($basePower * $variation, 2);
                $consumption = round(rand(30, 80), 2);
            }

            // حفظ القراءات ف جدول energy_data
            EnergyData::create([
                'panel_id'    => $panel->id,
                'power'       => $power,
                'consumption' => $consumption, // الكولون الجديد
                'voltage'     => rand(220, 240),
                'current'     => rand(2, 8),
                'energy_kwh'  => round($power / 1000, 4),
                'created_at'  => $time,
                'updated_at'  => $time,
            ]);
        }

        return redirect()->route('panels.index')->with('success', 'Votre panneau a été ajouté avec ses données initiales.');
    }

    public function destroy(Panel $panel)
    {
        if ($panel->user_id !== Auth::id()) {
            return abort(403, 'Non autorisé');
        }

        $panel->delete();
        return back()->with('success', 'Supprimé avec succès.');
    }
}