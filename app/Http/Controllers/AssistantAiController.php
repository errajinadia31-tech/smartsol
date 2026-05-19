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
        $hour = now()->format('H');

        // ======================
        // Validation
        // ======================
        if ($cap <= 0) {
            return response()->json(['error' => 'السعة غير صحيحة'], 400);
        }

        if ($prod < 0) {
            return response()->json(['error' => 'الإنتاج غير صالح'], 400);
        }

        // ======================
        // Historical Data
        // ======================
        $panelIds = Panel::where('user_id', Auth::id())->pluck('id');

        $history = EnergyData::whereIn('panel_id', $panelIds)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->pluck('power');

        $avg = $history->count() > 0 ? $history->avg() : $prod;

        // ======================
        // Efficiency
        // ======================
        $currentEfficiency = ($prod / $cap) * 100;
        $currentEfficiency = max(0, min(100, $currentEfficiency));
        $eff = round($currentEfficiency, 2);

        // ======================
        // Status Logic
        // ======================
        if ($eff < 20) {
            $status = 'critical_low';
        } elseif ($eff < 50) {
            $status = 'low';
        } elseif ($prod < ($avg * 0.5) && $avg > 10) {
            $status = 'drop';
        } else {
            $status = 'normal';
        }

        // ======================
        // Trend
        // ======================
        $diff = $prod - $avg;
        $trend = $diff >= 0 ? "تحسن" : "تراجع";

        // ======================
        // AI Prompt
        // ======================
$prompt = "
أنت خبير طاقة. الوقت: {$hour}. الإنتاج: {$prod}W. الكفاءة: {$currentEfficiency}%.
التعليمات:
- إذا كان الوقت بين 20:00 و 06:00: قل 'السيستيم دابا فوضعية راحة، نتلاقة غدا مع الشمش'.
- إذا كان الوقت نهارا والكفاءة < 15%: قل 'كاين خلل، غالبا البانوات فيهم الغبار'.
- ممنوع ذكر الأرقام الطويلة أو الحسابات المعقدة.
- جاوب بجملة وحدة قصيرة ومباشرة بالدارجة المغربية.
";

        // ======================
        // API Key
        // ======================
        $apiKey = config('services.groq.api_key');

        if (!$apiKey) {
            return response()->json(['error' => 'API KEY ناقص'], 500);
        }

        // ======================
        // Groq API Call
        // ======================
        try {
            $response = Http::withToken($apiKey)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    // F l-Controller, s7e7 l-content dyal system message:
'messages' => [
    [
        'role' => 'system', 
        'content' => 'أنت خبير طاقة شمسية مغربي. مهمتك هي تحليل البيانات وإعطاء نصيحة واحدة مختصرة جدا بالدارجة. ممنوع ذكر الأرقام التقنية المملة (مثل 12.9291) إلا إذا كانت ضرورية جدا. ركز على "الحالة" و "شنو خاص يدار".'
    ],
    [
        'role' => 'user', 
        'content' => "البيانات: إنتاج {$prod}W، كفاءة {$currentEfficiency}%، وقت: {$hour}. قارن واعطيني الخلاصة."
    ]
],
                    'temperature' => 0.2,
                    'max_tokens' => 120
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'خطأ في الاتصال بالذكاء الاصطناعي'
                ], 500);
            }

            // ======================
            // Response
            // ======================
            return response()->json([
                'analysis' => $response['choices'][0]['message']['content'],
                'efficiency' => $eff,
                'status' => $status,
                'trend' => $trend,
                'average' => round($avg, 2),
                'weather' => $weather,
                'hour' => $hour
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ غير متوقع',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}