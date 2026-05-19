<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private string $groqUrl = 'https://api.groq.com/openai/v1/chat/completions';

    public function ask(Request $request): JsonResponse
    {
        $request->validate([
            'message'         => 'required|string|max:1000',
            'production_kwh'  => 'nullable|numeric|min:0',
            'consumption_kwh' => 'nullable|numeric|min:0',
            'weather'         => 'nullable|string|in:sunny,cloudy,rainy,partly_cloudy',
        ]);

        $systemPrompt = $this->buildSystemPrompt(
            $request->production_kwh,
            $request->consumption_kwh,
            $request->weather
        );

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post($this->groqUrl, [
                'model'       => env('GROQ_MODEL', 'llama3-8b-8192'),
                'max_tokens'  => 400,
                'temperature' => 0.6,
                'messages'    => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => $request->message],
                ],
            ]);

            // ── DEBUG (retire après fix) ──────────────────────────────────
            Log::info('GROQ_STATUS', ['code' => $response->status()]);
            Log::info('GROQ_BODY',   ['body' => $response->body()]);
            // ─────────────────────────────────────────────────────────────

            if ($response->failed()) {
                Log::error('Groq API failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return response()->json([
                    'answer' => 'عفواً، وقع مشكل مع الخادم. عاود المحاولة من بعد شوية. 🔧',
                    'error'  => true,
                ], 200);
            }

            $answer = $response->json('choices.0.message.content', 'ما قدرتش نفهم الجواب.');

            return response()->json([
                'answer' => trim($answer),
                'error'  => false,
                'meta'   => [
                    'production_kwh'  => $request->production_kwh,
                    'consumption_kwh' => $request->consumption_kwh,
                    'weather'         => $request->weather,
                    'deficit'         => $this->calcDeficit(
                        $request->production_kwh,
                        $request->consumption_kwh
                    ),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot exception', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return response()->json([
                'answer' => 'وقع خطأ تقني: ' . $e->getMessage(),
                'error'  => true,
            ], 200);
        }
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function buildSystemPrompt(
        ?float $production,
        ?float $consumption,
        ?string $weather
    ): string {
        $context = '';

        if ($production !== null && $consumption !== null) {
            $deficit    = $production - $consumption;
            $efficiency = $production > 0
                ? round(($production / max($consumption, 1)) * 100, 1)
                : 0;
            $status = $deficit >= 0 ? 'فائض' : 'عجز';

            $context = <<<EOT

=== بيانات النظام الحالية ===
- الإنتاج: {$production} kWh
- الاستهلاك: {$consumption} kWh
- الفرق ({$status}): {$deficit} kWh
- نسبة الكفاءة: {$efficiency}%
- حالة الطقس: {$weather}
EOT;
        }

        return <<<EOT
أنت SolarBot، خبير ذكي في أنظمة الطاقة الشمسية. تتحدث بالدارجة المغربية فقط.
أسلوبك: تقني لكن بسيط، منظم ومختصر.

مهمتك:
- تحلل الإنتاج مقارنة بالاستهلاك
- تكتشف مشاكل الإنتاج الضعيف
- تشرح تأثير الطقس (شمس / غيوم / مطر)
- تعطي توصيات عملية لتحسين الكفاءة
- تقدم تحليل يومي أو أسبوعي عند الطلب

قواعد الجواب:
- استخدم الإيموجي بشكل معقول (🔴🟡🟢☀️☁️🌧️⚡)
- رتب الجواب: تشخيص ← سبب ← توصية
- أقصى 5 أسطر
- لا تتكلم إلا بالدارجة المغربية
{$context}
EOT;
    }

    private function calcDeficit(?float $production, ?float $consumption): ?float
    {
        if ($production === null || $consumption === null) return null;
        return round($production - $consumption, 2);
    }
}