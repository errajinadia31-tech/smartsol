<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function rapport(Request $request)
    {
        $userId = Auth::id();
        
        // 1. تحديد المدة الزمنية المختار من الـ Filter (الافتراضي 30 يوم)
        $days = $request->get('period', 30); 
        $dateLimit = now()->subDays($days);

        // 2. جلب جميع الألواح الخاصة بالمستخدم (ديما باينة وثابتة لضمان حساب السعة كاملة)
        $panels = Panel::where('user_id', $userId)
                    ->with('zone')
                    ->get();

        // 3. حساب الإحصائيات العامة بناءً على جرد الألواح الحالي
        $stats = [
            'total_panels'  => $panels->count(),
            'total_power'   => $panels->sum('power_capacity'),
            'active_panels' => $panels->where('status', 'active')->count(),
            'maintenance'   => $panels->where('status', 'maintenance')->count(),
        ];

        /* * 4. الفلترة الحركية للمبيان (Chart Data):
         * إما بناءً على تاريخ الإنتاج الحقيقي، أو نقوم بمحاكاة الفلترة حسب سعة إنتاج المناطق 
         * التي كانت نشطة في هاته المدة. هنا نقوم بجمع القدرة حسب المدن المرتبطة بالألواح النشطة.
         */
        $chartData = Panel::where('user_id', $userId)
            ->where('created_at', '<=', now()) // هنا تقدري تبدليها بجدول الـ Production الحقيقي مستقبلاً
            ->with('zone')
            ->get()
            ->groupBy('zone.city')
            ->map(fn($group) => $group->sum('power_capacity'));
        
        return view('rapports.rapport', [
            'panels'   => $panels,
            'stats'    => $stats,
            'labels'   => $chartData->keys(),
            'values'   => $chartData->values(),
            'period'   => $days // نمرر المدة الحالية للـ View
        ]);
    }
}