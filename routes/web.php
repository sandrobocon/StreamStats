<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\TwitchOauthCallbackController;
use App\Http\Livewire\Welcome;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', Welcome::class)->name('landing');

Route::get('/auth/twitch/redirect', function () {
    return Socialite::driver('twitch')->redirect();
})->name('oauth.twitch.redirect');

Route::get('/auth/twitch/callback', TwitchOauthCallbackController::class)->name('oauth.twitch.callback');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return response(Auth::user()->toArray());
    })->name('dashboard');

    Route::post('/logout', LogoutController::class)->name('logout');
});
