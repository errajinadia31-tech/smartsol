<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // 1. تحديد الفترة الزمنية
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
        } else {
            $start = now()->subDay(); // آخر 24 ساعة كوضع افتراضي
            $end = now();
        }

        // 2. توليد Fake Data
        $fakeData = collect();
        $current = clone $start;

        // إذا كان الفرق كبير (أكثر من 7 أيام)، نولد نقطة كل يوم عوض كل ساعة لسرعة التحميل
        $interval = $start->diffInDays($end) > 7 ? 'addDay' : 'addHour';

        while ($current <= $end) {
            $power = rand(150, 450);
            $voltage = rand(18, 24);
            $currentAmp = round($power / $voltage, 2);

            $fakeData->push((object)[
                'created_at' => clone $current,
                'power' => $power,
                'voltage' => $voltage,
                'current' => $currentAmp
            ]);

            $current->$interval(); 
        }

        $latestData = $fakeData->sortByDesc('created_at');

        return view('statistiques.index', compact('latestData'));
    }
}