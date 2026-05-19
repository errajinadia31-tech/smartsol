<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\EnergyData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalPanels = Panel::where('user_id', $userId)->count();
        $totalPower = Panel::where('user_id', $userId)->sum('power_capacity');
        $maintenanceCount = Panel::where('user_id', $userId)->where('status', 'maintenance')->count();
        $activePanelsCount = Panel::where('user_id', $userId)->where('status', 'active')->count();

        $panelIds = Panel::where('user_id', $userId)->pluck('id');

        // ✅ FIX ORDER (latest → correct chart)
        $latestReadings = EnergyData::whereIn('panel_id', $panelIds)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get()
            ->reverse();

        $currentProduction = $latestReadings->last()->power ?? 0;

        return view('dashboard', compact(
            'totalPanels',
            'totalPower',
            'maintenanceCount',
            'activePanelsCount',
            'latestReadings',
            'currentProduction'
        ));
    }

}