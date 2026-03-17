@include('partials.public-layout', ['pageTitle' => 'Projects', 'activePage' => 'projects'])

@php
    $profile = \Illuminate\Support\Facades\DB::table('profiles')->orderBy('id')->first();
    $projects = $profile
        ? \Illuminate\Support\Facades\DB::table('projects')
            ->where('profile_id', $profile->id)
            ->where('status', 'published')
            ->orderBy('featured', 'desc')
            ->orderBy('position')
            ->get()
        : collect();
@endphp

        {{-- Page Hero --}}
        <section class="pt-32 pb-16 px-6 bg-[#fafafa]">
            <div class="max-w-7xl mx-auto">
                <span class="text-accent font-semibold tracking-widest uppercase text-sm">Work</span>
                <h1 class="text-5xl lg:text-6xl mt-2 mb-4">Projects</h1>
                <p class="text-gray-500 text-lg max-w-xl">A collection of projects I've built, designed, and shipped.</p>
            </div>
        </section>

        {{-- Projects grid --}}
        <section class="py-20 px-6">
            <div class="max-w-7xl mx-auto">
                @if ($projects->count() === 0)
                    <div class="text-center py-24">
                        <p class="text-gray-400 text-lg">No projects published yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($projects as $project)
                            <article class="group hover-lift border border-gray-100 overflow-hidden">
                                <div class="aspect-video bg-gray-100 overflow-hidden">
                                    @if ($project->thumbnail_url)
                                        <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                                             class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h3 class="text-xl font-semibold group-hover:text-accent transition-colors">{{ $project->title }}</h3>
                                            @if ($project->subtitle)
                                                <p class="text-sm text-gray-400 mt-0.5">{{ $project->subtitle }}</p>
                                            @endif
                                        </div>
                                        @if ($project->featured)
                                            <span class="text-xs text-accent font-medium ml-2 shrink-0">★ Featured</span>
                                        @endif
                                    </div>
                                    @if ($project->summary)
                                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">{{ $project->summary }}</p>
                                    @endif
                                    @if ($project->client_name)
                                        <p class="text-xs text-gray-400 mt-3">Client: <span class="font-medium text-gray-600">{{ $project->client_name }}</span></p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- CTA --}}
        <section class="py-16 px-6 bg-[#fafafa] text-center border-t border-gray-100">
            <p class="text-gray-500 mb-4">Have a project in mind?</p>
            <a href="{{ route('contact.page') }}" class="bg-charcoal text-white px-8 py-4 font-medium text-sm uppercase tracking-widest hover:bg-accent transition-colors">
                Let's Talk
            </a>
        </section>

@include('partials.public-layout-end')
