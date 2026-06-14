<?php

namespace App\Services;

use App\Models\EnergyData;
use Illuminate\Support\Facades\Log;

class EnergyAnalyzerService
{
    public function getAnalytics($panelIds, $prod, $cap)
    {
        $today = EnergyData::whereIn('panel_id', $panelIds)
            ->where('created_at', '>=', now()->startOfDay())
            ->sum('power');

        $yesterday = EnergyData::whereIn('panel_id', $panelIds)
            ->whereBetween('created_at', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()])
            ->sum('power');
            
        $comparison = ($yesterday > 0) 
            ? ($today >= $yesterday ? 'الإنتاج اليوم أفضل من البارح.' : 'الإنتاج اليوم أقل من البارح.')
            : 'لا توجد بيانات كافية للمقارنة.';

        return ['comparison' => $comparison];
    }

    public function calculateSavings($panelIds, $pricePerKwh = 1.2) 
    {
        $totalWatts = EnergyData::whereIn('panel_id', $panelIds)
            ->where('created_at', '>=', now()->startOfDay())
            ->sum('power');

        if ($totalWatts <= 0) return 0.00;

        return round(($totalWatts / 1000) * $pricePerKwh, 2);
    }

    public function getTomorrowForecast($totalCap, $weather)
    {
        $multiplier = match ($weather) {
            'sunny' => 0.95,
            'cloudy' => 0.60,
            'rainy' => 0.20,
            default => 0.50,
        };
        return round($totalCap * $multiplier, 2);
    }

    public function getSummaryForAi($panelIds, $prod, $cap, $weather)
    {
        $analytics = $this->getAnalytics($panelIds, $prod, $cap);
        return [
            'prod'       => $prod,
            'savings'    => $this->calculateSavings($panelIds),
            'forecast'   => $this->getTomorrowForecast($cap, $weather),
            'comparison' => $analytics['comparison']
        ];
    }
}