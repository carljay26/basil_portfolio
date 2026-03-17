{{--
  Admin layout partial.
  Usage:
    @include('partials.admin-layout', ['title' => 'Page Title', 'active' => 'dashboard'])
    ... your page content here ...
    @include('partials.admin-layout-end')

  active values: dashboard | content | projects | messages | settings
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} — Portfolio Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        dialog::backdrop { background: rgba(15,15,15,.6); backdrop-filter: blur(4px); }
        dialog {
            box-shadow: 0 25px 60px rgba(0,0,0,.18);
            margin: 10vh auto;
            width: calc(100% - 3rem);
            max-width: 640px;
        }
        .nav-active { border-left: 3px solid #C5A059; background: rgba(197,160,89,.08); color: #1a1a1a; font-weight: 600; }
        .nav-item:not(.nav-active):hover { background: #f8f7f5; }
    </style>
</head>
<body class="antialiased text-gray-900" style="background:#f5f4f0;">
<div class="flex min-h-screen">

    {{-- ── Sidebar ─────────────────────────────────────────── --}}
    @php $activeNav = $active ?? 'dashboard'; @endphp
    <aside class="w-64 bg-white hidden md:flex flex-col sticky top-0 h-screen"
           style="border-right:1px solid #e8e6e1;">

        {{-- Logo --}}
        <div class="px-6 py-5" style="border-bottom:1px solid #e8e6e1;">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                     style="background:#1a1a1a;">
                    <span class="text-white font-bold text-sm tracking-tight">BF</span>
                </div>
                <div class="leading-tight">
                    <p class="text-sm font-bold text-gray-900 tracking-tight">Portfolio Admin</p>
                    <p class="text-xs text-gray-400">Management Panel</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            @php
                $navItems = [
                    [
                        'key'   => 'dashboard',
                        'label' => 'Dashboard',
                        'route' => 'admin.dashboard',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                    ],
                    [
                        'key'   => 'content',
                        'label' => 'Content',
                        'route' => 'admin.content',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
                    ],
                    [
                        'key'   => 'projects',
                        'label' => 'Projects',
                        'route' => 'admin.projects',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>',
                    ],
                    [
                        'key'   => 'messages',
                        'label' => 'Messages',
                        'route' => 'admin.messages',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                    ],
                    [
                        'key'   => 'settings',
                        'label' => 'Settings',
                        'route' => 'admin.settings',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    ],
                ];
            @endphp

            <p class="px-3 pt-1 pb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400">Navigation</p>

            @foreach ($navItems as $item)
                @php
                    $unread = 0;
                    if ($item['key'] === 'messages') {
                        $unread = \Illuminate\Support\Facades\DB::table('contact_messages')->where('is_read', 0)->count();
                    }
                @endphp
                <a href="{{ route($item['route']) }}"
                   class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors
                          {{ $activeNav === $item['key'] ? 'nav-active' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 shrink-0 {{ $activeNav === $item['key'] ? 'text-accent' : '' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $item['icon'] !!}
                    </svg>
                    <span>{{ $item['label'] }}</span>
                    @if ($unread > 0)
                        <span class="ml-auto text-[10px] font-bold rounded-full px-2 py-0.5 text-white"
                              style="background:#C5A059;">{{ $unread }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- Footer: profile + logout --}}
        @php $adminProfile = \Illuminate\Support\Facades\DB::table('profiles')->orderBy('id')->first(); @endphp
        <div class="px-4 py-4" style="border-top:1px solid #e8e6e1;">
            <div class="flex items-center gap-3">
                @if ($adminProfile?->profile_image_url)
                    <img alt="Avatar"
                         class="w-9 h-9 rounded-full border-2 object-cover shrink-0"
                         style="border-color:#e8e6e1;"
                         src="{{ $adminProfile->profile_image_url }}">
                @else
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold shrink-0"
                         style="background:#1a1a1a; color:#C5A059;">
                        {{ $adminProfile ? strtoupper(substr($adminProfile->name, 0, 2)) : 'BF' }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate text-gray-900">{{ $adminProfile?->name ?: 'Administrator' }}</p>
                    <p class="text-xs text-gray-400">Administrator</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" title="Logout"
                            class="p-1.5 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── Main ─────────────────────────────────────────────── --}}
    <main class="flex-1 overflow-y-auto min-w-0">
