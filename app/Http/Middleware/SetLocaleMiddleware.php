<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // كنتشكيو واش الـ Session فيها الكلي ديال اللّغة
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        } else {
            // إلا مكانتش، كانديرو اللغة الافتراضية ديال السيستم
            App::setLocale(config('app.locale', 'fr'));
        }

        return $next($request);
    }
}