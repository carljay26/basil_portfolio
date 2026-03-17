@include('partials.public-layout', ['pageTitle' => 'About Me', 'activePage' => 'about'])

@php
    $na = fn ($v) => isset($v) && trim((string) $v) !== '' ? $v : 'N/A';
    $profile = \Illuminate\Support\Facades\DB::table('profiles')->orderBy('id')->first();
    $fullName = $profile?->name ?: 'N/A';
    $bio = $na($profile?->bio);
    $title = $na($profile?->title);
    $location = $na($profile?->location);
    $email = $na($profile?->email);
    $phone = $na($profile?->phone);
    $languages = $na($profile?->languages);
    $currentEngagement = $na($profile?->current_engagement);
    $quote = $na($profile?->quote);
    $avatarUrl = $profile?->profile_image_url ?: null;
    $experiences = $profile
        ? \Illuminate\Support\Facades\DB::table('experiences')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->get()
        : collect();
@endphp

        {{-- Page Hero --}}
        <section class="pt-32 pb-16 px-6 bg-[#fafafa]">
            <div class="max-w-7xl mx-auto">
                <span class="text-accent font-semibold tracking-widest uppercase text-sm">About</span>
                <h1 class="text-5xl lg:text-6xl mt-2 mb-4">About Me</h1>
                <p class="text-gray-500 text-lg max-w-xl">{{ $title }}</p>
            </div>
        </section>

        {{-- Main content --}}
        <section class="py-20 px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-14">
                {{-- Left: photo + quick info --}}
                <div class="lg:col-span-4 space-y-6">
                    <div class="aspect-[3/4] bg-gray-200 overflow-hidden grayscale hover:grayscale-0 transition-all duration-700">
                        @if ($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $fullName }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">N/A</div>
                        @endif
                    </div>
                    <div class="border border-gray-100 p-6 space-y-4">
                        <div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Email</p>
                            <p class="text-sm font-medium">{{ $email }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Phone</p>
                            <p class="text-sm font-medium">{{ $phone }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Location</p>
                            <p class="text-sm font-medium">{{ $location }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Languages</p>
                            <p class="text-sm font-medium">{{ $languages }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Current Status</p>
                            <p class="text-sm font-medium">{{ $currentEngagement }}</p>
                        </div>
                    </div>
                </div>

                {{-- Right: bio + experience --}}
                <div class="lg:col-span-8 space-y-12">
                    <div>
                        <h2 class="section-title text-3xl">Biography</h2>
                        <p class="text-gray-600 leading-relaxed text-lg mt-6">{{ $bio }}</p>
                    </div>

                    @if ($quote !== 'N/A')
                        <blockquote class="border-l-4 border-accent pl-6 italic text-gray-600 text-lg">
                            "{{ $quote }}"
                        </blockquote>
                    @endif

                    <div>
                        <h2 class="section-title text-3xl">Experience</h2>
                        @if ($experiences->count() === 0)
                            <p class="text-gray-500 mt-6">N/A</p>
                        @else
                            <div class="space-y-5 mt-6">
                                @foreach ($experiences as $exp)
                                    <div class="border-l-2 border-gray-100 pl-8 relative hover-lift">
                                        <div class="absolute w-3 h-3 rounded-full -left-[7px] top-2 {{ $exp->is_current ? 'bg-accent' : 'bg-gray-300' }}"></div>
                                        <p class="text-lg font-semibold text-charcoal">{{ $exp->title }}</p>
                                        <p class="text-sm text-gray-500 mt-0.5">
                                            {{ $na($exp->company) }}
                                            @if ($na($exp->role) !== 'N/A') &bull; {{ $na($exp->role) }} @endif
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $na($exp->start_date) }} – {{ $exp->is_current ? 'Present' : $na($exp->end_date) }}
                                        </p>
                                        @if ($na($exp->description) !== 'N/A')
                                            <p class="text-gray-600 mt-2 leading-relaxed">{{ $exp->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="py-16 px-6 bg-charcoal text-white text-center">
            <h2 class="text-3xl mb-4">Let's Work Together</h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">Open to new opportunities. Let's create something great.</p>
            <a href="{{ route('contact.page') }}" class="bg-accent text-charcoal px-8 py-4 font-medium text-sm uppercase tracking-widest hover:opacity-90 transition-opacity">
                Get In Touch
            </a>
        </section>

@include('partials.public-layout-end')
