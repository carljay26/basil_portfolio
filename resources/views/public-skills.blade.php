@include('partials.public-layout', ['pageTitle' => 'Skills & Tools', 'activePage' => 'skills'])

@php
    $profile = \Illuminate\Support\Facades\DB::table('profiles')->orderBy('id')->first();
    $skills = $profile
        ? \Illuminate\Support\Facades\DB::table('skills')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->get()
        : collect();
    $tools = $profile
        ? \Illuminate\Support\Facades\DB::table('tools')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->get()
        : collect();
    $skillCategories = $skills->groupBy('category');
    $toolCategories = $tools->groupBy('category');
@endphp

        {{-- Page Hero --}}
        <section class="pt-32 pb-16 px-6 bg-[#fafafa]">
            <div class="max-w-7xl mx-auto">
                <span class="text-accent font-semibold tracking-widest uppercase text-sm">Expertise</span>
                <h1 class="text-5xl lg:text-6xl mt-2 mb-4">Skills &amp; Tools</h1>
                <p class="text-gray-500 text-lg max-w-xl">Technologies and tools I use to bring ideas to life.</p>
            </div>
        </section>

        {{-- Skills --}}
        <section class="py-20 px-6">
            <div class="max-w-7xl mx-auto">
                <h2 class="section-title text-3xl mb-12">Technical Skills</h2>
                @if ($skills->count() === 0)
                    <p class="text-gray-400">N/A</p>
                @else
                    @foreach ($skillCategories as $category => $catSkills)
                        @if ($category)
                            <h3 class="text-xs uppercase tracking-widest text-gray-400 mb-4 mt-8">{{ $category }}</h3>
                        @endif
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($catSkills as $skill)
                                <div class="glass-card hover-lift p-5 text-center border border-gray-100 bg-[#fafafa]">
                                    @if ($skill->icon_url)
                                        <img src="{{ $skill->icon_url }}" alt="{{ $skill->name }}" class="w-10 h-10 mx-auto mb-3 object-contain">
                                    @else
                                        <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-400">
                                            {{ strtoupper(mb_substr($skill->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <p class="text-sm font-medium">{{ $skill->name }}</p>
                                    @if ($skill->proficiency)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $skill->proficiency }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

        {{-- Tools --}}
        <section class="py-20 px-6 bg-[#fafafa] border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <h2 class="section-title text-3xl mb-12">Tools &amp; Technologies</h2>
                @if ($tools->count() === 0)
                    <p class="text-gray-400">N/A</p>
                @else
                    @foreach ($toolCategories as $category => $catTools)
                        @if ($category)
                            <h3 class="text-xs uppercase tracking-widest text-gray-400 mb-4 mt-8">{{ $category }}</h3>
                        @endif
                        <div class="flex flex-wrap gap-3">
                            @foreach ($catTools as $tool)
                                <div class="border border-gray-200 bg-white px-4 py-3 flex items-center gap-3 hover-lift">
                                    @if ($tool->icon_url)
                                        <img src="{{ $tool->icon_url }}" alt="{{ $tool->name }}" class="w-6 h-6 object-contain">
                                    @endif
                                    <p class="text-sm font-medium">{{ $tool->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

        {{-- CTA --}}
        <section class="py-16 px-6 bg-charcoal text-white text-center">
            <h2 class="text-3xl mb-4">Want to work together?</h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">Let's discuss how my skills can help your project succeed.</p>
            <a href="{{ route('contact.page') }}" class="bg-accent text-charcoal px-8 py-4 font-medium text-sm uppercase tracking-widest hover:opacity-90 transition-opacity">
                Contact Me
            </a>
        </section>

@include('partials.public-layout-end')
