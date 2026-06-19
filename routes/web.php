<?php

use App\Http\Controllers\AssistantAiController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\EnergyDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\SetLocaleMiddleware;
use App\Models\EnergyData;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');




// --- Routes with Localization & Web Session ---
Route::middleware(['web', SetLocaleMiddleware::class])->group(function () {

    // Switch Language Route
    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['ar', 'fr' ,'en'])) {
            session()->put('locale', $locale);
            session()->save(); 
        }
        return redirect()->back();
    })->name('lang.switch');

    // --- Authenticated & Verified Routes (الوسط للي محمي وخاصو الترجمة) ---
    Route::middleware(['auth', 'verified'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/simulation', [DashboardController::class, 'getSimulationData'])->name('simulation.data');

        // SmartSol AI & Chatbot
        Route::post('/analyze-energy', [AssistantAiController::class, 'analyzeEnergy'])->name('analyze.energy');
        Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');

        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Resources (الـ CRUD كاملين دابا غايوليو مترجمين)
        Route::resource('zones', ZoneController::class);
        Route::resource('panels', PanelController::class);
        Route::resource('energy-data', EnergyDataController::class);
        Route::resource('reports', ReportController::class);
        
        // Extra Report Route
        Route::get('/repport', [ReportController::class, 'rapport'])->name('rapport');

        // Notifications
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    });
    Route::get('/companies', function () {
    return view('companies.companie');
})->name('companies');

});

Route::get('/admin/print-view', function () {
    $users = User::all(); // جلب جميع المستخدمين
    return view('admin.print', compact('users')); // قمنا بتعديل الاسم هنا ليطابق اسم ملفك
})->name('admin.users.print')->middleware(['web', 'auth']);


Route::get('/admin/energy-print', function () {
    $energyDatas = EnergyData::all();
    return view('admin.print-energy', compact('energyDatas'));
})->name('admin.energy-data.print')->middleware(['web', 'auth']);


// Route::get('/test-sms', function () {

//     $user = \App\Models\User::find(9);

//     \Log::info('Phone: ' . $user->phone_number);

//     $user->notify(
//         new \App\Notifications\LowProductionSmsNotification(50)
//     );

//     return 'SMS Sent';
// });
require __DIR__.'/auth.php';