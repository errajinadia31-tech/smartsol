<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\EnergyData;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function rapport(Request $request)
    {
        $userId = Auth::id();
        
        // 1. تحديد المدة (افتراضي 30 يوم) مع حصرها في القيم المطلوبة
        $days = (int) $request->get('period', 30);
        if (!in_array($days, [7, 15, 30, 90])) {
            $days = 30;
        }
        
        $dateLimit = now()->subDays($days);

        // 2. جلب البيانات الأساسية للألواح
        $panels = Panel::where('user_id', $userId)->with('zone')->get();

        // 3. حساب إجمالي الاستهلاك
        $totalConsumption = EnergyData::whereHas('panel', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('created_at', '>=', $dateLimit)
            ->sum('consumption');

        // 4. حساب التوفير
        $totalSavings = EnergyData::whereHas('panel', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->sum('energy_kwh') * 1.2;

        // 5. حفظ التقرير في قاعدة البيانات (بدون تكرار لنفس اليوم ونفس المدة)
        Report::firstOrCreate(
            [
                'user_id'     => $userId,
                'period_days' => $days,
                'created_at'  => Carbon::today(),
            ],
            [
                'total_energy' => $totalConsumption,
                'date_from'    => $dateLimit,
                'date_to'      => now(),
            ]
        );

        // 6. جلب التقارير لعرضها في الجدول
        $reports = Report::where('user_id', $userId)
                         ->latest()
                         ->get();

        // 7. تجهيز البيانات للـ Dashboard
        $stats = [
            'total_panels'      => $panels->count(),
            'total_power'       => $panels->sum('power_capacity'),
            'total_consumption' => $totalConsumption,
            'active_panels'     => $panels->where('status', 'active')->count(),
            'maintenance'       => $panels->where('status', 'maintenance')->count(),
            'daily_economy'     => number_format($totalSavings, 2) . ' MAD',
        ];

        // 8. تجهيز بيانات المبيان
        $chartData = $panels->groupBy(fn($p) => $p->zone->city ?? 'N/A')
                            ->map(fn($group) => $group->sum('power_capacity'));

        // 9. إرجاع الـ View
        return view('rapports.rapport', [
            'panels'    => $panels,
            'stats'     => $stats,
            'labels'    => $chartData->keys(),
            'values'    => $chartData->values(),
            'period'    => $days,
            'savings'   => number_format($totalSavings, 2),
            'reports'   => $reports
        ]);
    }
}