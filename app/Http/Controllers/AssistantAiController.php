<?php

namespace App\Http\Controllers;

use App\Models\EnergyData;
use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AssistantAiController extends Controller
{
    
   public function analyzeEnergy(Request $request)
{
    $prod = (float) $request->input('prod');
    $cap  = (float) $request->input('cap');
    $weather = $request->input('weather', 'unknown');
    $hour = (int) now()->format('H'); 

    if ($cap <= 0) return response()->json(['error' => 'السعة غير صحيحة'], 400);
    if ($prod < 0) return response()->json(['error' => 'الإنتاج غير صالح'], 400);

    $panelIds = Panel::where('user_id', Auth::id())->pluck('id');

    // 1. جلب متوسط آخر 12 قراءة (للحالة اللحظية)
    $history = EnergyData::whereIn('panel_id', $panelIds)
        ->orderBy('created_at', 'desc')
        ->limit(12)
        ->pluck('power');
    $avg = $history->count() > 0 ? $history->avg() : $prod;

    // 2. المقارنة التاريخية (اليوم ضد البارح)
    $todayProd = EnergyData::whereIn('panel_id', $panelIds)
        ->whereDate('created_at', now()->toDateString())
        ->sum('power');

    $yesterdayProd = EnergyData::whereIn('panel_id', $panelIds)
        ->whereDate('created_at', now()->subDay()->toDateString())
        ->sum('power');

    $comparison = "";
    if ($yesterdayProd > 0) {
        $diff = (($todayProd - $yesterdayProd) / $yesterdayProd) * 100;
        $comparison = ($diff >= 0) ? "الإنتاج اليوم زايد بـ " . round($diff) . "% على البارح." : "الإنتاج اليوم ناقص بـ " . round(abs($diff)) . "% على البارح.";
    } else {
        $comparison = "ماكاينش داتا كافية ديال البارح للمقارنة.";
    }

    // 3. تحديد الحالة (Status)
    $currentEfficiency = max(0, min(100, ($prod / $cap) * 100));
    $eff = round($currentEfficiency, 2);

    if ($eff < 20) $status = 'critical_low';
    elseif ($eff < 50) $status = 'low';
    elseif ($prod < ($avg * 0.5) && $avg > 10) $status = 'drop';
    else $status = 'normal';

    $trend = ($prod - $avg) >= 0 ? "تحسن" : "تراجع";

    // 4. الاتصال بـ Groq AI
    $apiKey = config('services.groq.api_key');
    try {
        $response = Http::withToken($apiKey)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    [
                        'role' => 'system', 
                        'content' => "أنت خبير طاقة شمسية ومساعد ذكي لـ 'SmartSol'. تحدث بالدارجة المغربية فقط. 1. جاوب بجملة واحدة قصيرة. 2. ممنوع الأرقام الطويلة. 3. إذا كان الوقت ليلاً: 'السيستيم دابا فوضع راحة، نتلاقاو غدا مع الشمش إن شاء الله.' 4. إذا كان الإنتاج ناقص بزايد على البارح أو كاين ضعف، ركز على ضرورة التنظيف أو فحص الألواح."
                    ],
                    [
                        'role' => 'user', 
                        'content' => "البيانات: 
                            - الوقت: {$hour}:00 
                            - المقارنة: {$comparison}
                            - الإنتاج الحالي: {$prod} Watts 
                            - الكفاءة: {$eff}% 
                            - الحالة: {$status}
                            - الطقس: {$weather}
                            عطيني تحليل سريع ونصيحة بالدارجة."
                    ]
                ],
                'temperature' => 0.1, 
                'max_tokens' => 150 
            ]);

        return response()->json([
            'analysis' => trim($response->json()['choices'][0]['message']['content']),
            'efficiency' => $eff,
            'status' => $status
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'خطأ في الاتصال بالذكاء الاصطناعي'], 500);
    }
}
  
}