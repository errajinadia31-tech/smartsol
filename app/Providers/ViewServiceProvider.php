<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // هذا الكود يجعل $notifications متاحاً في أي صفحة تستخدم layout.blade.php
        View::composer('layouts.layout', function ($view) {
            $view->with('notifications', Notification::where('user_id', Auth::id())
                ->latest()
                ->limit(5)
                ->get());
        });
    }
}