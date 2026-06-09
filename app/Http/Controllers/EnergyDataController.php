<?php

namespace App\Http\Controllers;

use App\Models\EnergyData;
use Illuminate\Http\Request;

class EnergyDataController extends Controller
{

public function getChartData($panel_id) {
    $panel = auth()->user()->panels()->findOrFail($panel_id);

    $data = $panel->energyData() 
                ->latest()
                ->take(20)
                ->get(['voltage', 'current', 'power', 'created_at']);
                
    return response()->json($data);
}

}
