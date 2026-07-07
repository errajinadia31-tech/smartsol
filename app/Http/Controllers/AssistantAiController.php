<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Services\EnergyAnalyzerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AssistantAiController extends Controller
{
  public function analyzeEnergy(Request $request, EnergyAnalyzerService $service)
{
    $validated = $request->validate([
        'prod' => 'required|numeric|min:0',
        'cap'  => 'required|numeric|gt:0',
    ]);

    $panelIds = Panel::where('user_id', Auth::id())->pluck('id');
    $weather = 'sunny';
    $summary = $service->getSummaryForAi($panelIds, $validated['prod'], $validated['cap'], $weather);

    // التحقق من الوقت غير للـ AI
    $hour = (int) now()->format('H');
    $analysis = ($hour >= 20 || $hour < 6) 
        ? 'النظام في وضع الراحة حالياً، نتلاقاو مع الشمس غداً إن شاء الله! 🌙☀️' 
        : $this->callAiProvider($summary, $weather)['analysis'];

    // كترجعي الأرقام ديما، والـ analysis على حساب الوقت
    return response()->json([
        'analysis' => $analysis,
        'metrics'  => [
            'savings' => $summary['savings'],
            'forecast' => $summary['forecast']
        ]
    ]);
}

    private function callAiProvider($summary, $weather)
    {
        try {
            $apiKey = config('services.groq.api_key');
$userPrompt = "تحليل الإنتاج: {$summary['prod']}w. التوفير: {$summary['savings']} درهم. التوقعات لغداً: {$summary['forecast']}w. حالة الجو: {$weather}. قدم ملخصاً مركزاً.";
            $response = Http::timeout(15)->withToken($apiKey)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                ['role' => 'system', 'content' => "أنت واجهة ذكاء اصطناعي تقنية لمنصة SmartSol. مهمتك هي تقديم ملخص رقمي فقط. لا تستخدم عبارات ترحيبية أو كلام عاطفي و ممنوع التكرار . ابدأ مباشرة بالأرقام: 'الإنتاج الحالي: [X]، التوفير المحقق: [Y]، توقعات غداً: [Z]'. اختم بنصيحة تقنية واحدة فقط في جملة قصيرة جداً. استخدم لغة عربية تقنية ومباشرة."],
                ['role' => 'user', 'content' => $userPrompt]
                ],
                'temperature' => 0.2,
                'max_tokens' => 150
            ]);

            if ($response->successful()) {
                return ['analysis' => trim($response->json()['choices'][0]['message']['content'])];
            }
        } catch (\Exception $e) {
            return ['analysis' => 'تعذر الاتصال بالخادم.'];
        }
        return ['analysis' => 'تحليل غير متاح حالياً.'];
    }
}