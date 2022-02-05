<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class TwitchOauthCallbackController extends Controller
{
    public function __invoke()
    {
        $twitchUser = Socialite::driver('twitch')->user();

        $user = User::where('twitch_id', $twitchUser->id)->first();

        if (!$user) {
            $user = User::create([
                'twitch_id' => $twitchUser->id,
                'name'      => $twitchUser->name,
                'email'     => $twitchUser->email,
                'password'  => Str::random(),
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
