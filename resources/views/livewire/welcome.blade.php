<x-card class="flex flex-col items-center space-y-6 my-4">
    <h1 class="text-2xl text-center">
        Get a quick look at how the channels you watch compare to the top 1000 live streams.
    </h1>
    <a href="{{ route('oauth.twitch.redirect') }}" class="w-full">
        <x-button primary lg class="w-full">
            <img src="{{ asset('img/twitch-logo.png') }}" class="w-8 h-8 my-3" alt="">
            Login with your Twitch account
        </x-button>
    </a>
</x-card>
