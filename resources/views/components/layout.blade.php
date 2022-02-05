<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body x-data="{}">
<div>
    {{ $slot }}
</div>
<script src="{{ mix('js/app.js') }}" defer></script>
@livewireScripts
</body>
</html>
