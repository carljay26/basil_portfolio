 <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \Illuminate\Support\Facades\DB::table('profiles')->value('name') ?: 'Portfolio' }} | Portfolio</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --charcoal: #1a1a1a;
            --accent:   #C5A059;
        }
        .accent-line::after {
            content: '';
            display: block;
            width: 36px;
            height: 2px;
            background: var(--accent);
            margin-top: 10px;
        }
        .btn-primary {
            display: inline-block;
            padding: .85rem 2rem;
            background: var(--charcoal);
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            transition: background .25s, color .25s;
        }
        .btn-primary:hover { background: var(--accent); }
        .btn-outline {
            display: inline-block;
            padding: .85rem 2rem;
            border: 1.5px solid var(--charcoal);
            color: var(--charcoal);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            transition: background .25s, color .25s;
        }
        .btn-outline:hover { background: var(--charcoal); color: #fff; }
        .nav-link {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            transition: color .2s;
        }
        .nav-link:hover { color: var(--accent); }
        .project-card { transition: transform .3s ease, box-shadow .3s ease; }
        .project-card:hover { transform: translateY(-4px); }
        .skill-item { transition: color .2s; }
        .skill-item:hover h4 { color: var(--accent); }
        .star-gold { color: #C5A059; }
        .input-underline {
            width: 100%;
            border: none;
            border-bottom: 1px solid #e5e7eb;
            background: transparent;
            padding: .75rem 0;
            font-size: .875rem;
            outline: none;
            transition: border-color .2s;
        }
        .input-underline:focus { border-bottom-color: var(--accent); }
        .section-divider {
            width: 40px;
            height: 2px;
            background: var(--accent);
            margin: .75rem 0 2rem;
        }
    </style>
</head>
<body class="antialiased" style="color:#1a1a1a; background:#fff;">

@php
    $profile = \Illuminate\Support\Facades\DB::table('profiles')->orderBy('id')->first();
    $na = fn ($v) => isset($v) && trim((string) $v) !== '' ? $v : null;

    $fullName         = $profile?->name ?: 'Portfolio';
    $title            = $na($profile?->title);
    $tagline          = $na($profile?->tagline);
    $bio              = $na($profile?->bio);
    $availability     = $na($profile?->availability);
    $avatarUrl        = $na($profile?->profile_image_url);
    $resumeUrl        = $na($profile?->resume_url);
    $email            = $na($profile?->email);
    $phone            = $na($profile?->phone);
    $location         = $na($profile?->location);
    $discordUrl       = $na($profile?->discord_url);
    $gmailUrl         = $na($profile?->gmail_url);
    $facebookUrl      = $na($profile?->facebook_url);
    $languages        = $na($profile?->languages);
    $currentEngagement= $na($profile?->current_engagement);
    $quote            = $na($profile?->quote);
    $expYears         = $profile?->experience_years;
    $projectsCount    = $profile?->projects_count;
    $clientsCount     = $profile?->clients_count;
    $satisfScore      = $na($profile?->satisfaction_score);

    $projects = $profile
        ? \Illuminate\Support\Facades\DB::table('projects')
            ->where('profile_id', $profile->id)
            ->where('status', 'published')
            ->orderBy('featured', 'desc')
            ->orderBy('position')
            ->limit(6)
            ->get()
        : collect();

    $experiences = $profile
        ? \Illuminate\Support\Facades\DB::table('experiences')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->limit(8)
            ->get()
        : collect();

    $clients = $profile
        ? \Illuminate\Support\Facades\DB::table('clients')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->limit(12)
            ->get()
        : collect();

    $reviews = $profile
        ? \Illuminate\Support\Facades\DB::table('satisfactions')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->limit(6)
            ->get()
        : collect();

    $skills = $profile
        ? \Illuminate\Support\Facades\DB::table('skills')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->limit(12)
            ->get()
        : collect();

    $tools = $profile
        ? \Illuminate\Support\Facades\DB::table('tools')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->limit(16)
            ->get()
        : collect();
@endphp

{{-- ══════════════════════════════════════════
     NAV
══════════════════════════════════════════ --}}
<nav class="fixed w-full z-50" style="background:rgba(255,255,255,.92); backdrop-filter:blur(12px); border-bottom:1px solid rgba(0,0,0,.06);">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-base font-bold tracking-tighter" style="letter-spacing:-.02em;">
            @if ($fullName !== 'Portfolio')
                {{ strtoupper(substr($fullName, 0, 1)) }}.&thinsp;{{ strtoupper(trim(strstr($fullName, ' '))) }}
            @else
                PORTFOLIO
            @endif
        </div>
        <div class="hidden md:flex items-center gap-8">
            <a href="#about"    class="nav-link">About</a>
            <a href="#projects" class="nav-link">Projects</a>
            <a href="#expertise" class="nav-link">Expertise</a>
            <a href="#contact"  class="nav-link">Contact</a>
        </div>
        @if ($resumeUrl)
            <a data-track-click="nav_resume" href="{{ $resumeUrl }}" target="_blank"
               class="hidden md:block text-xs font-bold uppercase tracking-widest px-4 py-2 transition-all"
               style="border:1.5px solid #1a1a1a;">
                Resume
            </a>
        @endif
    </div>
</nav>

<main>

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section id="hero" style="background:#faf9f7; padding-top:9rem; padding-bottom:6rem;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            {{-- Text --}}
            <div class="lg:col-span-7 xl:col-span-6">
                @if ($availability)
                    <div class="inline-flex items-center gap-2 mb-6">
                        <span class="w-2 h-2 rounded-full" style="background:#22c55e;"></span>
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-500">{{ $availability }}</span>
                    </div>
                @endif

                @if ($title)
                    <p class="text-sm font-bold uppercase tracking-[.2em] mb-3" style="color:#C5A059;">{{ $title }}</p>
                @endif

                <h1 class="text-5xl lg:text-6xl xl:text-7xl leading-[1.05] mb-6">
                    {!! nl2br(e($fullName)) !!}
                </h1>

                @if ($tagline)
                    <p class="text-lg text-gray-600 mb-8 max-w-xl leading-relaxed">{{ $tagline }}</p>
                @elseif ($bio)
                    <p class="text-lg text-gray-600 mb-8 max-w-xl leading-relaxed">{{ Str::limit($bio, 160) }}</p>
                @endif

                <div class="flex flex-wrap gap-3 mb-10">
                    <a data-track-click="hero_contact" href="#contact" class="btn-primary">Get In Touch</a>
                    <a data-track-click="hero_projects" href="#projects" class="btn-outline">View Projects</a>
                    @if ($resumeUrl)
                        <a data-track-click="hero_resume" href="{{ $resumeUrl }}" target="_blank"
                           class="inline-flex items-center gap-2 px-6 py-3 text-xs font-bold uppercase tracking-widest transition-colors hover:text-accent"
                           style="border:1px solid #e5e7eb;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Resume
                        </a>
                    @endif
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-8" style="border-top:1px solid #e5e7eb;">
                    <div>
                        <p class="text-2xl font-bold">{{ $expYears !== null ? $expYears.'+' : '—' }}</p>
                        <p class="text-xs uppercase tracking-widest text-gray-400 mt-1">Experience</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $projectsCount !== null ? $projectsCount.'+' : ($projects->count() ?: '—') }}</p>
                        <p class="text-xs uppercase tracking-widest text-gray-400 mt-1">Projects</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $clientsCount !== null ? $clientsCount.'+' : '—' }}</p>
                        <p class="text-xs uppercase tracking-widest text-gray-400 mt-1">Clients</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $satisfScore ?? '—' }}</p>
                        <p class="text-xs uppercase tracking-widest text-gray-400 mt-1">Satisfaction</p>
                    </div>
                </div>
            </div>

            {{-- Photo --}}
            <div class="lg:col-span-5 xl:col-span-6 flex justify-center lg:justify-end">
                <div class="relative">
                    <div class="w-80 h-96 lg:w-96 lg:h-[480px] overflow-hidden" style="background:#e5e7eb;">
                        @if ($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $fullName }}"
                                 class="w-full h-full object-cover transition-all duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Floating card --}}
                    <div class="absolute -bottom-5 -left-8 p-5 shadow-xl hidden lg:block" style="background:#fff; min-width:180px;">
                        <p class="text-xs font-bold uppercase tracking-[.15em] text-gray-400 mb-1">Current Role</p>
                        <p class="text-sm font-semibold" style="color:#1a1a1a;">{{ $currentEngagement ?? ($title ?? 'Designer & Developer') }}</p>
                    </div>
                    {{-- Accent square --}}
                    <div class="absolute -top-4 -right-4 w-20 h-20 hidden lg:block" style="background:#C5A059; opacity:.15;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     ABOUT
══════════════════════════════════════════ --}}
<section id="about" style="padding:6rem 0;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-4">
                <p class="text-xs font-bold uppercase tracking-[.2em] mb-2" style="color:#C5A059;">01 — About</p>
                <h2 class="text-4xl">About Me</h2>
                <div class="section-divider"></div>
            </div>

            <div class="lg:col-span-8 space-y-12">

                {{-- Bio --}}
                @if ($bio)
                    <div>
                        <h3 class="text-xl font-bold mb-3">Bio</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $bio }}</p>
                    </div>
                @endif

                {{-- Contact Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-5" style="border:1px solid #e5e7eb;">
                        <p class="text-[10px] font-bold uppercase tracking-[.15em] text-gray-400 mb-2">Email</p>
                        <p class="text-sm font-medium truncate">{{ $email ?? '—' }}</p>
                    </div>
                    <div class="p-5" style="border:1px solid #e5e7eb;">
                        <p class="text-[10px] font-bold uppercase tracking-[.15em] text-gray-400 mb-2">Phone</p>
                        <p class="text-sm font-medium">{{ $phone ?? '—' }}</p>
                    </div>
                    <div class="p-5" style="border:1px solid #e5e7eb;">
                        <p class="text-[10px] font-bold uppercase tracking-[.15em] text-gray-400 mb-2">Location</p>
                        <p class="text-sm font-medium">{{ $location ?? '—' }}</p>
                    </div>
                </div>

                {{-- Experience --}}
                @if ($experiences->count() > 0)
                    <div class="mt-10">
                        <h3 class="text-xl font-bold mb-5 text-center">Experience</h3>
                        <div class="space-y-4 max-w-2xl mx-auto">
                            @foreach ($experiences as $exp)
                                <div class="flex gap-5 p-5" style="border:1px solid #e5e7eb;">
                                    <div class="w-1 shrink-0 rounded-full self-stretch" style="background:#C5A059;"></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                                            <p class="font-bold">{{ $exp->title }}</p>
                                            @if ($exp->is_current)
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                                      style="background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0;">
                                                    Current
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm mb-1" style="color:#C5A059;">
                                            {{ $exp->company ?? '—' }}
                                            @if ($exp->role) <span class="text-gray-400">· {{ $exp->role }}</span> @endif
                                        </p>
                                        <p class="text-xs text-gray-400 mb-2">
                                            {{ $exp->start_date ?? '?' }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ?? '?') }}
                                        </p>
                                        @if ($exp->description)
                                            <p class="text-sm text-gray-600">{{ $exp->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     PROJECTS
══════════════════════════════════════════ --}}
<section id="projects" style="background:#1a1a1a; padding:6rem 0; color:#fff;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
            <div>
                <p class="text-xs font-bold uppercase tracking-[.2em] mb-2" style="color:#C5A059;">02 — Work</p>
                <h2 class="text-4xl text-white">Projects</h2>
                <div class="section-divider"></div>
            </div>
            @if ($projects->count() > 3)
                <p class="text-sm text-gray-400">Showing {{ $projects->count() }} projects</p>
            @endif
        </div>

        @if ($projects->count() === 0)
            <div class="py-16 text-center">
                <p class="text-gray-500">No published projects yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($projects as $idx => $project)
                    <div class="project-card group relative overflow-hidden cursor-pointer
                                {{ $project->featured && $idx === 0 ? 'md:col-span-2' : '' }}"
                         style="border:1px solid rgba(255,255,255,.08);">
                        {{-- Thumbnail or placeholder --}}
                        @if ($project->thumbnail_url)
                            <div class="h-52 overflow-hidden {{ $project->featured && $idx === 0 ? 'md:h-72' : '' }}">
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                                     class="w-full h-full object-cover transition-all duration-500 scale-100 group-hover:scale-105">
                            </div>
                        @else
                            <div class="h-44 flex items-center justify-center" style="background:rgba(255,255,255,.03);">
                                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="p-7">
                            <div class="flex items-center gap-3 mb-3">
                                @if ($project->featured)
                                    <span class="text-[10px] font-bold uppercase tracking-[.15em] px-2.5 py-1"
                                          style="background:#C5A059; color:#1a1a1a;">Featured</span>
                                @endif
                                <span class="text-[10px] font-bold uppercase tracking-[.15em] text-gray-500">
                                    {{ $project->client_name ?? 'Personal Project' }}
                                </span>
                            </div>
                            <h3 class="text-xl text-white mb-2">{{ $project->title }}</h3>
                            @if ($project->subtitle)
                                <p class="text-sm text-gray-400 mb-3">{{ $project->subtitle }}</p>
                            @endif
                            @if ($project->summary)
                                <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">{{ $project->summary }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════
     CLIENTS
══════════════════════════════════════════ --}}
@if ($clients->count() > 0)
<section id="clients" style="padding:5rem 0; background:#faf9f7;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-[.2em] mb-2" style="color:#C5A059;">Trusted By</p>
            <h2 class="text-3xl">Clients</h2>
            <div class="w-8 h-0.5 mx-auto mt-3" style="background:#C5A059;"></div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach ($clients as $c)
                <a href="{{ $c->website_url ?? '#' }}"
                   class="group flex flex-col items-center gap-3 p-5 transition-all hover:-translate-y-0.5"
                   style="border:1px solid #e5e7eb; background:#fff;"
                   @if (!$c->website_url) aria-disabled="true" @endif>
                    <div class="w-12 h-12 overflow-hidden flex items-center justify-center" style="background:#f5f4f0;">
                        @if ($c->logo_url)
                            <img src="{{ $c->logo_url }}" alt="{{ $c->name }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-sm font-bold text-gray-400">
                                {{ strtoupper(substr($c->name, 0, 2)) }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs font-semibold text-center text-gray-700 leading-tight">{{ $c->name }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     EXPERTISE & TOOLS
══════════════════════════════════════════ --}}
<section id="expertise" style="padding:6rem 0;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Skills --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-[.2em] mb-2" style="color:#C5A059;">03 — Skills</p>
                <h2 class="text-3xl mb-1">Expertise</h2>
                <div class="section-divider"></div>
                @if ($skills->count() === 0)
                    <p class="text-gray-400 text-sm">No skills listed.</p>
                @else
                    <div class="space-y-3 mt-2">
                        @foreach ($skills as $skill)
                            <div class="skill-item flex items-center justify-between group py-3"
                                 style="border-bottom:1px solid #f0ede8;">
                                <div>
                                    <h4 class="font-bold text-base transition-colors">{{ $skill->name }}</h4>
                                    @if ($skill->category)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $skill->category }}</p>
                                    @endif
                                </div>
                                <svg class="w-4 h-4 text-gray-200 group-hover:text-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Tools --}}
            <div style="background:#faf9f7; padding:2.5rem;">
                <h2 class="text-2xl mb-1">Tools</h2>
                <div class="section-divider"></div>
                @if ($tools->count() === 0)
                    <p class="text-gray-400 text-sm">No tools listed.</p>
                @else
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach ($tools as $tool)
                            <span class="px-4 py-2 text-xs font-bold tracking-[.12em] uppercase transition-colors hover:border-charcoal"
                                  style="background:#fff; border:1px solid #e5e7eb;">
                                {{ $tool->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
                @if ($languages)
                    <div class="mt-8">
                        <p class="text-[10px] font-bold uppercase tracking-[.15em] text-gray-400 mb-2">Languages</p>
                        <p class="text-sm font-medium">{{ $languages }}</p>
                    </div>
                @endif
            </div>

            {{-- Quote / Engagement --}}
            <div class="flex flex-col justify-center items-center text-center p-10" style="border:1px solid #e5e7eb;">
                <div class="w-12 h-px mb-8" style="background:#C5A059;"></div>
                @if ($quote)
                    <p class="text-2xl italic leading-relaxed mb-6" style="font-family:'Playfair Display', serif;">
                        "{{ $quote }}"
                    </p>
                @endif
                @if ($currentEngagement)
                    <p class="text-[10px] font-bold uppercase tracking-[.18em] text-gray-400 mb-1">
                        Current Engagement
                    </p>
                    <p class="font-semibold">{{ $currentEngagement }}</p>
                @endif
                <div class="w-12 h-px mt-8" style="background:#C5A059;"></div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     SATISFACTION / REVIEWS
══════════════════════════════════════════ --}}
@if ($reviews->count() > 0)
<section id="reviews" style="padding:6rem 0; background:#faf9f7;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="text-xs font-bold uppercase tracking-[.2em] mb-2" style="color:#C5A059;">04 — Reviews</p>
            <h2 class="text-3xl">Satisfaction</h2>
            <div class="w-8 h-0.5 mx-auto mt-3" style="background:#C5A059;"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($reviews as $r)
                <div class="bg-white p-8" style="border:1px solid #e5e7eb;">
                    {{-- Stars --}}
                    @if ($r->rating)
                        <div class="flex gap-1 mb-5">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4" fill="{{ $i <= $r->rating ? '#C5A059' : 'none' }}"
                                     stroke="{{ $i <= $r->rating ? '#C5A059' : '#d1d5db' }}" viewBox="0 0 24 24">
                                    <path stroke-linejoin="round" stroke-width="1.5"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            @endfor
                        </div>
                    @endif
                    <p class="text-gray-600 leading-relaxed mb-6 italic">"{{ $r->content }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold text-white"
                             style="background:#1a1a1a;">
                            {{ strtoupper(substr($r->author_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-sm">{{ $r->author_name }}</p>
                            @if ($r->author_role)
                                <p class="text-xs text-gray-400">{{ $r->author_role }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     CONTACT
══════════════════════════════════════════ --}}
<section id="contact" style="padding:6rem 0;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

            {{-- Info --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-[.2em] mb-2" style="color:#C5A059;">05 — Contact</p>
                <h2 class="text-4xl lg:text-5xl leading-tight mb-3">
                    Let's build something <em style="color:#C5A059; font-style:italic;">remarkable</em>.
                </h2>
                <div class="section-divider"></div>
                <p class="text-gray-500 mb-10 max-w-md leading-relaxed">
                    Available for freelance opportunities, collaborative projects, and consulting in UI/UX design and IT.
                </p>

                <div class="space-y-5 mb-10">
                    @if ($email)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 flex items-center justify-center shrink-0" style="background:#faf9f7; border:1px solid #e5e7eb;">
                                <svg class="w-4 h-4" fill="none" stroke="#C5A059" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Email</p>
                                <p class="text-sm font-medium">{{ $email }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($phone)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 flex items-center justify-center shrink-0" style="background:#faf9f7; border:1px solid #e5e7eb;">
                                <svg class="w-4 h-4" fill="none" stroke="#C5A059" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Phone</p>
                                <p class="text-sm font-medium">{{ $phone }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($location)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 flex items-center justify-center shrink-0" style="background:#faf9f7; border:1px solid #e5e7eb;">
                                <svg class="w-4 h-4" fill="none" stroke="#C5A059" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Location</p>
                                <p class="text-sm font-medium">{{ $location }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Social links --}}
                @if ($gmailUrl || $facebookUrl || $discordUrl)
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[.18em] text-gray-400 mb-3">Connect</p>
                        <div class="flex flex-wrap gap-3">
                            @if ($gmailUrl)
                                <a href="{{ $gmailUrl }}"
                                   class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold uppercase tracking-widest transition-all hover:bg-charcoal hover:text-white"
                                   style="border:1.5px solid #1a1a1a;">Gmail</a>
                            @endif
                            @if ($facebookUrl)
                                <a href="{{ $facebookUrl }}" target="_blank"
                                   class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold uppercase tracking-widest transition-all hover:bg-charcoal hover:text-white"
                                   style="border:1.5px solid #1a1a1a;">Facebook</a>
                            @endif
                            @if ($discordUrl)
                                <a href="{{ $discordUrl }}" target="_blank"
                                   class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold uppercase tracking-widest transition-all hover:bg-charcoal hover:text-white"
                                   style="border:1.5px solid #1a1a1a;">Discord</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Form --}}
            <div class="p-10" style="background:#faf9f7; border:1px solid #e5e7eb;">
                @if (session('contact_sent'))
                    <div class="flex items-center gap-3 rounded-lg px-4 py-3 mb-6 text-sm"
                         style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Your message has been sent!
                    </div>
                @endif

                <h3 class="text-xl font-bold mb-6">Send a Message</h3>

                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[.15em] mb-2 text-gray-600">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input name="name" type="text" required placeholder="Your full name"
                               class="input-underline">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[.15em] mb-2 text-gray-600">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input name="email" type="email" required placeholder="your@email.com"
                               class="input-underline">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[.15em] mb-2 text-gray-600">
                            Subject
                        </label>
                        <input name="subject" type="text" placeholder="What is this about?"
                               class="input-underline">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[.15em] mb-2 text-gray-600">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" rows="4" required placeholder="Tell me about your project..."
                                  class="input-underline resize-none"></textarea>
                    </div>
                    <button data-track-click="contact_submit" type="submit" class="btn-primary w-full text-center">
                        Send Inquiry →
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

</main>

{{-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ --}}
<footer style="background:#1a1a1a; padding:3rem 0;">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-xs text-gray-500">
            &copy; {{ date('Y') }} {{ $fullName }}. All rights reserved.
        </p>
        <p class="text-xs" style="color:#C5A059;">
            Portfolio — Designed &amp; Developed with Purpose
        </p>
    </div>
</footer>

</body>
</html>
