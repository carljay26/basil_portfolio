{{--
  Public layout partial.
  Usage:
    @include('partials.public-layout', ['pageTitle' => 'About', 'activePage' => 'about'])
    ... content ...
    @include('partials.public-layout-end')

  activePage values: home | about | projects | skills | reviews | contact
--}}
@php
    $pubProfile = \Illuminate\Support\Facades\DB::table('profiles')->orderBy('id')->first();
    $pubFullName = $pubProfile?->name ?: 'Portfolio';
    $pubEmail    = $pubProfile?->email ?: '#';
    $pubPhone    = $pubProfile?->phone ?: null;
    $pubLocation = $pubProfile?->location ?: null;
    $pubDiscord  = $pubProfile?->discord_url ?: null;
    $pubGmail    = $pubProfile?->gmail_url ?: null;
    $pubFacebook = $pubProfile?->facebook_url ?: null;
    $pubActivePage = $activePage ?? 'home';
    $navLinks = [
        ['href' => url('/'), 'key' => 'home', 'label' => 'Home'],
        ['href' => route('about'), 'key' => 'about', 'label' => 'About'],
        ['href' => route('projects.public'), 'key' => 'projects', 'label' => 'Projects'],
        ['href' => route('skills.public'), 'key' => 'skills', 'label' => 'Skills'],
        ['href' => route('reviews.public'), 'key' => 'reviews', 'label' => 'Reviews'],
        ['href' => route('contact.page'), 'key' => 'contact', 'label' => 'Contact'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Portfolio' }} — {{ $pubFullName }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-charcoal antialiased">

    {{-- Navigation --}}
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tighter hover:text-accent transition-colors">
                {{ strtoupper(mb_substr($pubFullName, 0, 1)) }}. {{ strtoupper(str($pubFullName)->after(' ')) }}
            </a>
            <div class="hidden md:flex space-x-8 text-sm font-medium uppercase tracking-widest">
                @foreach ($navLinks as $nl)
                    <a href="{{ $nl['href'] }}"
                       class="{{ $pubActivePage === $nl['key'] ? 'text-accent border-b border-accent pb-0.5' : 'hover:text-accent transition-colors' }}">
                        {{ $nl['label'] }}
                    </a>
                @endforeach
            </div>
            {{-- Mobile menu button --}}
            <button id="mobileMenuBtn" class="md:hidden p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </button>
        </div>
        <div id="mobileMenu" class="hidden md:hidden border-t border-gray-100 bg-white">
            @foreach ($navLinks as $nl)
                <a href="{{ $nl['href'] }}" class="block px-6 py-3 text-sm font-medium {{ $pubActivePage === $nl['key'] ? 'text-accent' : 'text-gray-700 hover:text-accent' }}">{{ $nl['label'] }}</a>
            @endforeach
        </div>
    </nav>

    <main>
