<?php

use App\Http\Controllers\TwitchOauthCallbackController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/auth/twitch/redirect', function () {
    return Socialite::driver('twitch')->redirect();
})->name('oauth.twitch.redirect');

Route::get('/auth/twitch/callback', TwitchOauthCallbackController::class)->name('oauth.twitch.callback');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return response(Auth::user()->toArray());
    })->name('dashboard');
});
