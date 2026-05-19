<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json(['reply' => 'صيفط شي ميساج أولا!']);
        }

        // قراءة الـ API Key مباشرة من الـ .env لتفادي مشاكل الـ Cache
        $apiKey = env('GROQ_API_KEY');

        if (!$apiKey) {
            return response()->json(['reply' => 'سْمْح ليا، الـ API Key ناقص فالسيستم، تأكد من ملف .env!']);
        }

        // الـ Prompt مركز فقط على التحليل التقني والأعطال والصيانة بالدارجة المغربية
        $systemPrompt = "أنت عبارة عن 'Agent AI' خبير تقني مغربي نَاضِي ومطور مخصص لأنظمة الطاقة الشمسية لسيستم اسمه 'SmartSol'.\n"
    . "مهمتك الأساسية هي الدردشة مع المستخدم بالدارجة المغربية القحة (Moroccan Darija) فقط وفقط، ومساعدته في تشخيص الأعطال والاستشارات التقنية (Dépannage).\n\n"
    . "قواعد صارمة ومقدسة للإجابة (إلى خالفتيها غاتخسر السيستيم):\n"
    . "1. ممنوع منعا كلياً ومطلقاً استعمال الكلمات المشرقية، الخليجية، أو اللبنانية (مثل: كيفك، حبيبي، يا رجل، شو، مش، عشان، هدا).\n"
    . "2. ممنوع استعمال اللغة العربية الفصحى الجافة في الترحيب أو الهضرة (مثل: أهلاً بك، يرجى، ما مشكلتك).\n"
    . "3. إذا صيفط ليك المستخدم سلام أو ترحيب، جاوبو فوراً بالدارجة المغربية التقنية وبأدب مغربي، بحال هكا:\n"
    . "   - 'وعليكم السلام! مرحبا بيك، أنا الـ Agent AI ديالك. إلا عندك أي مشكل فالـ Onduleur أو البانوات، قوليا شنو كاين ونعاونك تفرز المشكل.'\n"
    . "4. عند تشخيص أي عطل، قسم جوابك بنقاط مباشرة (المشكل، الأسباب، والحلول العملية) بلا تطويل.\n"
    . "5. استعمل ديما المصطلحات التقنية المغربية: البانوات، الانفرتر، الكابلاج، السيركوي، الشارج، الغبار.\n\n"
    . "هاك أمثلة حقيقية لأسلوبك الحتمي:\n"
    . "المستخدم: salam\n"
    . "أنت: وعليكم السلام وخا معندناش الشمش دابا حيت السيستيم فوضع راحة! هانيا، قولي أشنو المشكل التقني لي عندك فالسيستيم باش نعاونك؟\n\n"
    . "المستخدم: البانوات مابغاووش يشارجيوا\n"
    . "أنت: هاد البلان يقدر يكون بسباب بزاف د الحوايج: أولا، شوف واش كاين الغبار بزاف فوق البانوات خاصهم يتمسحو. ثانيا، قلب الكابلاج واش شي خيط مرخوف من جيهة الـ Onduleur. جرب هادو ورد عليا.";

        try {
            // الاتصال بـ Groq باستعمال الـ Token والموديل الصحيح الشغال
            $response = Http::withToken($apiKey)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant', // الموديل الناجح والسريع
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 400
                ]);

            // تشخيص الخطأ وإظهاره فوراً في الشات إن وجد من جهة الـ API
            if (!$response->successful()) {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? $response->body();
                return response()->json(['reply' => 'سْمْح ليا، وقع مشكل فـ Groq API: ' . $errorMessage]);
            }

            $data = $response->json();
            $botReply = $data['choices'][0]['message']['content'] ?? 'الرد رجع خاوي، عاود صيفط الميساج.';

            return response()->json(['reply' => trim($botReply)]);

        } catch (\Exception $e) {
            // تسجيل الخطأ في الـ Logs وقراءته
            Log::error('Chatbot Error: ' . $e->getMessage());
            return response()->json(['reply' => 'السيستم غير متاح حالياً، وقع خطأ: ' . $e->getMessage()], 500);
        }
    }
}