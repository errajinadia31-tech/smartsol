<?php

use App\Http\Controllers\AssistantAiController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\EnergyDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    // Zones route
    Route::resource('zones', ZoneController::class);
    
    // Panels route
    Route::resource('panels', PanelController::class);

    // Energy Data route
    Route::resource('energy-data', EnergyDataController::class);
    
    //  Reports route
    Route::resource('reports', ReportController::class);

    // Notifications route
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

});

Route::get('/statistiques', [DashboardController::class, 'Statistiques'])
    ->middleware(['auth', 'verified'])
    ->name('statistiques');
    
    
    Route::get('/repport', [ReportController::class, 'rapport'])
        ->middleware(['auth', 'verified'])
        ->name('rapport');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/analyze-energy', [AssistantAiController::class, 'analyzeEnergy'])->name('analyze.energy');
    
    Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');
});
require __DIR__.'/auth.php';