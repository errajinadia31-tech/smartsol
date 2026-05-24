<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\Zone;
use App\Models\EnergyData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PanelController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $zones = Zone::all();
        $panels = Panel::where('user_id', $userId)->with('zone')->latest()->get();

        $weatherData = [];
        $apiKey = env('OPENWEATHER_API_KEY');

        $cities = $panels->pluck('zone.city')->unique()->filter();

        foreach ($cities as $city) {
            // استخدام الكاش لتسريع جلب الطقس (يحدث كل ساعة)
            $weatherData[$city] = Cache::remember("weather_city_{$city}", 3600, function () use ($city, $apiKey) {
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                    'q' => $city,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'fr'
                ]);
                return $response->successful() ? $response->json() : null;
            });
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

        $panel = Panel::create([
            'name'           => $request->name,
            'serial_number'  => $request->serial_number,
            'power_capacity' => $request->power_capacity,
            'status'         => $request->status,
            'user_id'        => Auth::id(), 
            'zone_id'        => $request->zone_id,
        ]);

        $this->generateData($panel);

        return redirect()->route('panels.index')->with('success', 'Le panneau ENERSOL a été ajouté avec succès.');
    }

public function update(Request $request, $id)
{
    $panel = Panel::findOrFail($id);

    $panel->update([
        'name' => $request->name,
        'serial_number' => $request->serial_number,
        'power_capacity' => $request->power_capacity,
        'status' => $request->status,
        'zone_id' => $request->zone_id,
    ]);

    return redirect()->back()->with('success', 'Panel updated successfully');
}


public function destroy(Panel $panel)
    {
        if ($panel->user_id !== Auth::id()) {
            return abort(403, 'Action non autorisée');
        }

        $panel->delete();
        return back()->with('success', 'Panneau supprimé avec succès.');
    }

    /**
     * منطق توليد بيانات الطاقة التلقائية
     */
    private function generateData(Panel $panel)
    {
        for ($i = 12; $i >= 0; $i--) {
            $time = Carbon::now()->subMinutes($i * 10);
            $basePower = $panel->power_capacity;
            $hour = $time->hour;

            if ($hour >= 7 && $hour <= 18) {
                $variation = rand(55, 95) / 100;
                $power = round($basePower * $variation, 2);
                $consumption = round(($power * 0.6) + rand(5, 15), 2);
            } else {
                $variation = rand(0, 5) / 100;
                $power = round($basePower * $variation, 2);
                $consumption = round(rand(30, 80), 2);
            }

            EnergyData::create([
                'panel_id'    => $panel->id,
                'power'       => $power,
                'consumption' => $consumption,
                'voltage'     => rand(220, 240),
                'current'     => rand(2, 8),
                'energy_kwh'  => round($power / 1000, 4),
                'created_at'  => $time,
            ]);
        }
    }
}