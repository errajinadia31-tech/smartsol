<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
public function rapport(Request $request)
{
    $userId = Auth::id();
    
    // تحديد المدة: 7، 15، 30 أو 90 يوم (الافتراضي 30)
    $days = $request->get('period', 30); 
    $dateLimit = now()->subDays($days);

    // جلب البيانات المفلترة حسب تاريخ الإنشاء
    $panels = Panel::where('user_id', $userId)
                ->where('created_at', '>=', $dateLimit)
                ->with('zone')
                ->get();

    $stats = [
        'total_panels' => $panels->count(),
        'total_power' => $panels->sum('power_capacity'),
        'active_panels' => $panels->where('status', 'active')->count(),
        'maintenance' => $panels->where('status', 'maintenance')->count(),
    ];

    // بيانات الرسوم البيانية
    $chartData = $panels->groupBy('zone.city')->map(fn($group) => $group->sum('power_capacity'));
    
    return view('rapports.rapport', [
        'panels' => $panels,
        'stats' => $stats,
        'labels' => $chartData->keys(),
        'values' => $chartData->values()
    ]);
}
}
