<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\EnergyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function rapport(Request $request)
    {
        $userId = Auth::id();
        
        // 1. تحديد المدة الزمنية المختارة من الـ Filter (الافتراضي 30 يوم)
        $days = (int) $request->get('period', 30); 
        $dateLimit = now()->subDays($days);

        // 2. جلب جميع الألواح الخاصة بالمستخدم مع منطقتها (استعلام واحد شامل)
        $panels = Panel::where('user_id', $userId)
                    ->with('zone')
                    ->get();

        // 3. حساب إجمالي الاستهلاك الحركي بناءً على الأيام المختارة (7، 15، 30، 90 يوم)
        // هكذا غاتجمع ليك الكارت داكشي اللي تسجل في هاد المدة بحال الداشبورد
        $totalConsumption = EnergyData::whereHas('panel', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('created_at', '>=', $dateLimit)
            ->sum('consumption');

        // 4. تجميع الإحصائيات العامة لإرسالها للـ Blade
        $stats = [
            'total_panels'      => $panels->count(),
            'total_power'       => $panels->sum('power_capacity'),
            'total_consumption' => $totalConsumption, // المجموع المتغير حسب الأيام
            'active_panels'     => $panels->where('status', 'active')->count(),
            'maintenance'       => $panels->where('status', 'maintenance')->count(),
        ];

        // 5. تجميع القدرة الإنتاجية حسب المدن للمبيان (Chart Data)
        $chartData = $panels->groupBy(function($panel) {
                return $panel->zone->city ?? __('N/A'); 
            })
            ->map(fn($group) => $group->sum('power_capacity'));
        
           $totalSavings = EnergyData::whereHas('panel', function($q) use ($userId) {
    $q->where('user_id', $userId);
})->sum('energy_kwh') * 1.2;

$stats['daily_economy'] = number_format($totalSavings, 2) . ' MAD';

        return view('rapports.rapport', [
            'panels'   => $panels,
            'stats'    => $stats,
            'labels'   => $chartData->keys(),
            'values'   => $chartData->values(),
            'period'   => $days,
            'savings'  => number_format($totalSavings, 2)
            ]);
    }
}