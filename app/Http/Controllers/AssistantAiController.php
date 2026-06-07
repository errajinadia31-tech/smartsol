<?php

namespace App\Http\Controllers;

use App\Models\EnergyData;
use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AssistantAiController extends Controller
{
    public function analyzeEnergy(Request $request)
    {
        try {

       
            $validated = $request->validate([
                'prod' => 'required|numeric|min:0',
                'cap' => 'required|numeric|gt:0',
                'weather' => 'nullable|string|max:255',
            ]);

            $prod = (float) $validated['prod'];
            $cap = (float) $validated['cap'];
            $weather = $validated['weather'] ?? 'غير معروف';

            $hour = (int) now()->format('H');

      
            if ($hour < 6 || $hour > 20) {
                return response()->json([
                    'analysis' => 'السيستيم دابا فوضع راحة، نتلاقاو غدا مع الشمش إن شاء الله ☀️',
                    'efficiency' => 0,
                    'status' => 'night'
                ]);
            }

            $currentEfficiency = ($prod / $cap) * 100;

            $eff = round(
                max(0, min(100, $currentEfficiency)),
                2
            );

         
            $status = match (true) {
                $eff < 10 => 'critical',
                $eff < 30 => 'low',
                $eff < 60 => 'medium',
                default => 'excellent',
            };

           
            $panelIds = Panel::where('user_id', Auth::id())
                ->pluck('id');

            
            $history = EnergyData::whereIn('panel_id', $panelIds)
                ->latest()
                ->limit(12)
                ->pluck('power');

            $avg = $history->count() > 0
                ? round($history->avg(), 2)
                : $prod;

     
            $todayProd = EnergyData::whereIn('panel_id', $panelIds)
                ->whereDate('created_at', now()->toDateString())
                ->sum('power');

            $yesterdayProd = EnergyData::whereIn('panel_id', $panelIds)
                ->whereDate('created_at', now()->subDay()->toDateString())
                ->sum('power');

            $comparison = 'ماكايناش داتا كافية للمقارنة.';

            if ($yesterdayProd > 0) {

                $comparison = $todayProd >= $yesterdayProd
                    ? 'الإنتاج اليوم أحسن من البارح.'
                    : 'الإنتاج اليوم أقل من البارح.';
            }

          
            $cacheKey = md5(
                $prod .
                $cap .
                $weather .
                $hour .
                $status
            );

        
            if (Cache::has($cacheKey)) {

                return response()->json(
                    Cache::get($cacheKey)
                );
            }

            $apiKey = config('services.groq.api_key');

            if (!$apiKey) {

                return response()->json([
                    'error' => 'Groq API Key غير موجود'
                ], 500);
            }

 
            $response = Http::timeout(15)
                ->withToken($apiKey)
                ->post('https://api.groq.com/openai/v1/chat/completions', [

                    'model' => 'llama-3.1-8b-instant',

                    'messages' => [

                        [
                            'role' => 'system',

                            'content' => "
أنت مساعد ذكي للطاقة الشمسية داخل تطبيق SmarSol.

جاوب بالدارجة المغربية فقط.

جاوب بجملة قصيرة ومفيدة.

إذا كانت الكفاءة ضعيفة اقترح:
- تنظيف الألواح
- فحص التوصيلات

إذا الأداء جيد شجع المستخدم.

ممنوع الشرح الطويل.
"
                        ],

                        [
                            'role' => 'user',

                            'content' => "
الساعة: {$hour}:00
الإنتاج الحالي: {$prod} واط
الكفاءة: {$eff}%
الطقس: {$weather}
المعدل العام: {$avg}
المقارنة: {$comparison}

عطيني تحليل قصير ونصيحة.
"
                        ]
                    ],

                    'temperature' => 0.2,
                    'max_tokens' => 80
                ]);

            // =========================
            // Success
            // =========================
            if ($response->successful()) {

                $analysis = trim(
                    $response->json()['choices'][0]['message']['content']
                );

                $data = [

                    'analysis' => $analysis,

                    'efficiency' => $eff,

                    'status' => $status,

                    'comparison' => $comparison,

                    'average_power' => $avg
                ];

                // Cache Result
                Cache::put(
                    $cacheKey,
                    $data,
                    now()->addMinutes(5)
                );

                return response()->json($data);
            }

            // =========================
            // API Error
            // =========================
            Log::error('Groq API Error', [
                'response' => $response->body()
            ]);

            return response()->json([
                'error' => 'تعذر الحصول على تحليل الذكاء الاصطناعي'
            ], 500);

        } catch (\Exception $e) {

            // =========================
            // Exception Log
            // =========================
            Log::error('AI Controller Error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'error' => ' مكاينش الواح شمسية أو وقع خطأ داخلي. حاول مرة أخرى.'
            ], 500);
        }
    }
}