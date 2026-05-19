<?php

namespace App\Http\Controllers;

use App\Models\EnergyData;
use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AssistantAiController extends Controller
{
    /**
     * 1. الفانكشن القديمة ديال زر Lancer Diagnostic (محمية ومقادة)
     */
    public function analyzeEnergy(Request $request)
    {
        $prod = (float) $request->input('prod');
        $cap  = (float) $request->input('cap');
        $weather = $request->input('weather', 'unknown');
        $hour = (int) now()->format('H'); 

        if ($cap <= 0) {
            return response()->json(['error' => 'السعة غير صحيحة'], 400);
        }

        if ($prod < 0) {
            return response()->json(['error' => 'الإنتاج غير صالح'], 400);
        }

        $panelIds = Panel::where('user_id', Auth::id())->pluck('id');

        $history = EnergyData::whereIn('panel_id', $panelIds)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->pluck('power');

        $avg = $history->count() > 0 ? $history->avg() : $prod;

        $currentEfficiency = ($prod / $cap) * 100;
        $currentEfficiency = max(0, min(100, $currentEfficiency));
        $eff = round($currentEfficiency, 2);

        if ($eff < 20) {
            $status = 'critical_low';
        } elseif ($eff < 50) {
            $status = 'low';
        } elseif ($prod < ($avg * 0.5) && $avg > 10) {
            $status = 'drop';
        } else {
            $status = 'normal';
        }

        $diff = $prod - $avg;
        $trend = $diff >= 0 ? "تحسن" : "تراجع";

        $apiKey = config('services.groq.api_key');

        if (!$apiKey) {
            return response()->json(['error' => 'API KEY ناقص فـ configuration'], 500);
        }

        try {
            $response = Http::withToken($apiKey)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant', // الموديل الصحيح والسرير
                    'messages' => [
                        [
                            'role' => 'system', 
                            'content' => "أنت خبير طاقة شمسية مغربي ومساعد ذكي لـ نظام 'SmartSol'. 
                            تحدث بالدارجة المغربية القحة (Moroccan Darija) فقط وفقط! 
                            ممنوع منعا كليا استعمال كلمات مصرية (مثل: دي، يا رجل، مش، عشان) أو فصحى مبالغ فيها.
                            
                            قواعد صارمة للإجابة:
                            1. جاوب بجملة واحدة قصيرة ومباشرة ومفيدة (Short and punchy).
                            2. ممنوع ذكر الأرقام الطويلة أو الحسابات المعقدة.
                            3. إذا كان الوقت ليلاً (بين 20 و 06): قل 'السيستيم دابا فوضع راحة، نتلاقاو غدا مع الشمش إن شاء الله.'
                            4. إذا كان الوقت نهاراً والكفاءة أقل من 15%: ركز على أن هناك خلل أو غبار على الألواح."
                        ],
                        [
                            'role' => 'user', 
                            'content' => "البيانات الحالية: 
                            - الوقت الحالي (الساعة): {$hour}:00
                            - الإنتاج الحالي: {$prod} Watts
                            - الكفاءة الحالية: {$eff}%
                            - حالة السيستيم: {$status}
                            - المنحنى مقارنة بالمعدل: {$trend}
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

    /**
     * 2. الفانكشن الجديدة والـ مْحَرّْشَة ديال الـ Chatbot التقني (بلا IoT وبنفس الـ API Key الناجح)
     */
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json(['reply' => 'صيفط شي ميساج أولا!']);
        }

        $apiKey = config('services.groq.api_key');

        if (!$apiKey) {
            return response()->json(['reply' => 'سْمْح ليا، الـ API Key ناقص فالسيستم، تأكد من ملف .env!']);
        }

        // Prompt محرررشششش خاص بالدعم التقني والأعطال وصيانة الـ Panels والـ Inverters
        $systemPrompt = "أنت عبارة عن 'Agent AI' خبير تقني مْحَرّْشْ ومطور جداً مخصص لأنظمة الطاقة الشمسية لسيستم اسمه 'SmartSol'.\n"
            . "مهمتك الأساسية هي الدردشة مع المستخدم، ومساعدته في تشخيص الأعطال التقنية والاستشارات (Dépannage & Assistance).\n\n"
            . "قواعد الإجابة الصارمة:\n"
            . "1. تحدث بالدارجة المغربية القحة (Moroccan Darija) بأسلوب ودّي، مهني، وتقني مبسط ومفهوم (ممنوع الفصحى الجافة وممنوع الكلمات الشرقية أو المصرية مثل 'مش' أو 'عشان').\n"
            . "2. عندما يطرح المستخدم أي مشكل تقني أو عطل، قم بتحليله فوراً واقترح:\n"
            . "   - سيناريوهات الأعطال الممكنة (Scénarios de panne possibles).\n"
            . "   - الأسباب المحتملة (Les causes).\n"
            . "   - الحلول التقنية والخطوات العملية الواضحة لإصلاح المشكل (Solutions techniques).\n"
            . "3. لا تذكر أي أرقام حية عن إنتاج اللوحات الحالي لأنك شات بوت مخصص للدعم والاستشارة والتحليل الفني فقط.\n"
            . "4. خلي الأجوبة ملوّزة، واضحة، ومباشرة بلا بلا بلا خاوي.";

        try {
            // صيفطنا الطلب بنفس الموديل الخفيف والسريع
            $response = Http::withToken($apiKey)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'temperature' => 0.5, // عطيناه شوية المرونة فالدردشة مقارنة بالدياغنوستيك
                    'max_tokens' => 400
                ]);

            if (!$response->successful()) {
                return response()->json(['reply' => 'سْمْح ليا، وقع عطل فالاتصال بـ Groq API. هاهو الـ Debug: ' . $response->json()['error']['message'] ?? $response->body()]);
            }

            $botReply = $response['choices'][0]['message']['content'] ?? 'الرد رجع خاوي، عاود صيفط الميساج.';
            return response()->json(['reply' => trim($botReply)]);

        } catch (\Exception $e) {
            return response()->json(['reply' => 'عْيِيتْ شوية دابا، وقع خطأ فالسيرفر: ' . $e->getMessage()]);
        }
    }
}