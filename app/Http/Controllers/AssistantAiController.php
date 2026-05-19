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
                    'messages' => [
                        [
                            'role' => 'system', 
                            'content' => "أنت خبير طاقة شمسية مغربي ومساعد ذكي لـ نظام 'SmartSol'. 
                            تحدث بالدارجة المغربية القحة (Moroccan Darija) فقط وفقط! 
                            ممنوع منعا كليا استعمال كلمات مصرية (مثل: دي، يا رجل، مش، عشان) أو فصحى مبالغ فيها.
                            
                            قواعد صارمة للإجابة:
                            1. جاوب بجملة واحدة قصيرة ومباشرة ومفيدة (Short and punchy).
                            2. ممنوع ذكر الأرقام الطويلة أو الحسابات المعقدة (مثلا بدلا من 1.01% قل 1%).
                            3. إذا كان الوقت ليلاً (بين 20 و 06): قل 'السيستيم دابا فوضع راحة، نتلاقاو غدا مع الشمش إن شاء الله.'
                            4. إذا كان الوقت نهاراً والكفاءة أقل من 15%: ركز على أن هناك خلل أو غبار على الألواح (مثال: 'كاين خلل، غالبا البانوات فيهم الغبار خاصهم يتمسحو')."
                        ],
                        [
                            'role' => 'user', 
                            'content' => "البيانات الحالية: 
                            - الوقت الحالي (الساعة): {$hour}:00
                            - الإنتاج الحالي: {$prod} Watts
                            - الكفاءة الحالية: {$eff}%
                            - حالة السيستيم: {$status}
                            - المنحنى مقارنة بالمعدل: {$trend} (المعدل هو: " . round($avg, 2) . "W)
                            - الطقس: {$weather}
                            
                            عطيني تحليل سريع ونصيحة بالدارجة المغربية."
                        ]
                    ],
                    'temperature' => 0.1, 
                    'max_tokens' => 250   
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'خطأ في الاتصال بالذكاء الاصطناعي',
                    'debug' => $response->body() 
                ], 500);
            }

            // ======================
            // Response
            // ======================
            return response()->json([
                'analysis' => trim($response['choices'][0]['message']['content']),
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