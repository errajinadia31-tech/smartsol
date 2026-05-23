<?php

namespace App\Http\Controllers;

use App\Models\EnergyData;
use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AssistantAiController extends Controller
{
    public function analyzeEnergy(Request $request)
    {
        $prod = (float) $request->input('prod');
        $cap  = (float) $request->input('cap');
        $weather = $request->input('weather', 'غير معروف');
        $hour = (int) now()->format('H');

        // 1. فحص أساسي للبيانات
        if ($cap <= 0) return response()->json(['error' => 'السعة غير صحيحة'], 400);
        if ($prod < 0) return response()->json(['error' => 'الإنتاج غير صالح'], 400);

        // 2. منطق الليل (توفير للـ API Calls والـ Tokens)
        if ($hour < 6 || $hour > 20) {
            return response()->json([
                'analysis' => 'السيستيم دابا فوضع راحة، نتلاقاو غدا مع الشمش إن شاء الله.',
                'efficiency' => 0,
                'status' => 'night'
            ]);
        }

        $panelIds = Panel::where('user_id', Auth::id())->pluck('id');

        // 3. تحليل البيانات التاريخية
        $history = EnergyData::whereIn('panel_id', $panelIds)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->pluck('power');
        $avg = $history->count() > 0 ? $history->avg() : $prod;

        $todayProd = EnergyData::whereIn('panel_id', $panelIds)
            ->whereDate('created_at', now()->toDateString())
            ->sum('power');

        $yesterdayProd = EnergyData::whereIn('panel_id', $panelIds)
            ->whereDate('created_at', now()->subDay()->toDateString())
            ->sum('power');

        $comparison = ($yesterdayProd > 0) 
            ? (($todayProd >= $yesterdayProd) ? "الإنتاج اليوم أحسن من البارح." : "الإنتاج اليوم أقل من البارح.")
            : "ماكاينش داتا كافية للمقارنة.";

        // 4. تحديد الكفاءة
        $currentEfficiency = max(0, min(100, ($prod / $cap) * 100));
        $eff = round($currentEfficiency, 2);

        $status = ($eff < 20) ? 'critical_low' : (($eff < 50) ? 'low' : 'normal');

        // 5. الاتصال بـ Groq AI
        $apiKey = config('services.groq.api_key');
        
        try {
            $response = Http::withToken($apiKey)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "أنت خبير طاقة شمسية ومساعد ذكي لـ 'EnerSol'. تحدث بالدارجة المغربية فقط وبطريقة ودودة. 1. جاوب بجملة واحدة قصيرة ومفيدة. 2. ممنوع الأرقام الطويلة. 3. إذا كان الإنتاج ضعيف أو كاين تراجع، نصح المستخدم بتنظيف الألواح أو فحص التوصيلات. 4. شجع المستخدم إذا كان الأداء جيد."
                        ],
                        [
                            'role' => 'user',
                            'content' => "البيانات: الساعة {$hour}:00، الإنتاج الحالي {$prod} واط، الكفاءة {$eff}%، الطقس: {$weather}. المقارنة: {$comparison}. عطيني تحليل ونصيحة."
                        ]
                    ],
                    'temperature' => 0.2,
                    'max_tokens' => 100
                ]);

            if ($response->successful()) {
                return response()->json([
                    'analysis' => trim($response->json()['choices'][0]['message']['content']),
                    'efficiency' => $eff,
                    'status' => $status
                ]);
            }

            return response()->json(['error' => 'تعذر الحصول على تحليل من الذكاء الاصطناعي'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => 'خطأ في الاتصال بالسيرفر'], 500);
        }
    }
}