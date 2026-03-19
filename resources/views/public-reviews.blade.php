@include('partials.public-layout', ['pageTitle' => 'Reviews', 'activePage' => 'reviews'])

@php
    $profile = \Illuminate\Support\Facades\DB::table('profiles')->orderBy('id')->first();
    $reviews = $profile
        ? \Illuminate\Support\Facades\DB::table('satisfactions')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->get()
        : collect();
    $clients = $profile
        ? \Illuminate\Support\Facades\DB::table('clients')
            ->where('profile_id', $profile->id)
            ->orderBy('position')
            ->get()
        : collect();
    $messages = \Illuminate\Support\Facades\DB::table('contact_messages')
        ->whereNotNull('reply')
        ->where('reply', '!=', '')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
@endphp

        {{-- Page Hero --}}
        <section class="pt-32 pb-16 px-6 bg-[#fafafa]">
            <div class="max-w-7xl mx-auto">
                <span class="text-accent font-semibold tracking-widest uppercase text-sm">Testimonials</span>
                <h1 class="text-5xl lg:text-6xl mt-2 mb-4">Reviews</h1>
                <p class="text-gray-500 text-lg max-w-xl">What clients and collaborators say about working with me.</p>
            </div>
        </section>

        {{-- Satisfaction / Testimonials --}}
        <section class="py-20 px-6">
            <div class="max-w-7xl mx-auto">
                @if ($reviews->count() === 0)
                    <p class="text-gray-400 text-center py-16">No reviews yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($reviews as $review)
                            <div class="border border-gray-100 p-8 hover-lift">
                                @if ($review->rating)
                                    <div class="flex gap-0.5 mb-4">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-accent' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                                @if ($review->content)
                                    <blockquote class="text-gray-600 leading-relaxed mb-6 italic">"{{ $review->content }}"</blockquote>
                                @endif
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-400">
                                        {{ strtoupper(mb_substr($review->author_name ?: '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold">{{ $review->author_name ?: 'Anonymous' }}</p>
                                        @if ($review->author_role)
                                            <p class="text-xs text-gray-400">{{ $review->author_role }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- Clients --}}
        @if ($clients->count() > 0)
            <section class="py-16 px-6 bg-[#fafafa] border-t border-gray-100">
                <div class="max-w-7xl mx-auto">
                    <h2 class="section-title text-3xl mb-12">Clients I've Worked With</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        @foreach ($clients as $client)
                            <div class="flex flex-col items-center gap-3 p-4 border border-gray-100 bg-white hover-lift">
                                @if ($client->logo_url)
                                    <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="h-10 object-contain transition-all">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-400">
                                        {{ strtoupper(mb_substr($client->name ?: '?', 0, 2)) }}
                                    </div>
                                @endif
                                <p class="text-xs text-gray-500 text-center">{{ $client->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Messages with replies --}}
        @if ($messages->count() > 0)
            <section class="py-16 px-6 border-t border-gray-100">
                <div class="max-w-5xl mx-auto">
                    <h2 class="section-title text-3xl mb-12">Messages</h2>
                    <div class="space-y-6">
                        @foreach ($messages as $msg)
                            <div class="border border-gray-100 p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-400 shrink-0">
                                        {{ strtoupper(mb_substr($msg->name ?: '?', 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-charcoal">{{ $msg->name }}</p>
                                        <p class="text-xs text-gray-400 mb-2">{{ $msg->created_at }}</p>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $msg->message }}</p>
                                        <div class="mt-4 pl-4 border-l-2 border-accent">
                                            <p class="text-xs font-medium text-accent mb-1 uppercase tracking-widest">Reply</p>
                                            <p class="text-gray-600 text-sm leading-relaxed">{{ $msg->reply }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

@include('partials.public-layout-end')
