@include('partials.public-layout', ['pageTitle' => 'Contact', 'activePage' => 'contact'])

@php
    $profile = \Illuminate\Support\Facades\DB::table('profiles')->orderBy('id')->first();
    $email = $profile?->email ?: null;
    $phone = $profile?->phone ?: null;
    $location = $profile?->location ?: null;
    $discordUrl = $profile?->discord_url ?: null;
    $gmailUrl = $profile?->gmail_url ?: null;
    $facebookUrl = $profile?->facebook_url ?: null;
@endphp

        {{-- Page Hero --}}
        <section class="pt-32 pb-16 px-6 bg-[#fafafa]">
            <div class="max-w-7xl mx-auto">
                <span class="text-accent font-semibold tracking-widest uppercase text-sm">Contact</span>
                <h1 class="text-5xl lg:text-6xl mt-2 mb-4">Get In Touch</h1>
                <p class="text-gray-500 text-lg max-w-xl">I'm open to new opportunities and collaborations. Let's talk.</p>
            </div>
        </section>

        {{-- Social / Quick Links --}}
        <section class="py-16 px-6 border-b border-gray-100">
            <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6">
                @if ($discordUrl)
                    <a href="{{ $discordUrl }}" target="_blank"
                       class="flex items-center gap-4 border border-gray-100 p-6 hover-lift group">
                        <div class="w-12 h-12 rounded-full bg-[#5865F2] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057c.002.022.015.043.031.056a19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 00-.041-.106 13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-0.5">Discord</p>
                            <p class="font-medium group-hover:text-accent transition-colors">Join Server</p>
                        </div>
                    </a>
                @endif

                @if ($gmailUrl)
                    <a href="{{ $gmailUrl }}" target="_blank"
                       class="flex items-center gap-4 border border-gray-100 p-6 hover-lift group">
                        <div class="w-12 h-12 rounded-full bg-[#EA4335] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 010 19.366V5.457c0-.904.732-1.636 1.636-1.636H3.82l8.18 6.136 8.182-6.136h2.182c.904 0 1.636.732 1.636 1.636z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-0.5">Gmail</p>
                            <p class="font-medium group-hover:text-accent transition-colors">Send Email</p>
                        </div>
                    </a>
                @endif

                @if ($facebookUrl)
                    <a href="{{ $facebookUrl }}" target="_blank"
                       class="flex items-center gap-4 border border-gray-100 p-6 hover-lift group">
                        <div class="w-12 h-12 rounded-full bg-[#1877F2] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-0.5">Facebook</p>
                            <p class="font-medium group-hover:text-accent transition-colors">Visit Profile</p>
                        </div>
                    </a>
                @endif
            </div>
        </section>

        {{-- Contact Form + Info --}}
        <section class="py-20 px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-14">
                {{-- Info --}}
                <div class="lg:col-span-4 space-y-8">
                    <div>
                        <h2 class="section-title text-3xl">Contact Info</h2>
                    </div>
                    @if ($email)
                        <div class="border-l-2 border-gray-100 pl-6">
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Email</p>
                            <a href="mailto:{{ $email }}" class="font-medium hover:text-accent transition-colors">{{ $email }}</a>
                        </div>
                    @endif
                    @if ($phone)
                        <div class="border-l-2 border-gray-100 pl-6">
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Phone</p>
                            <p class="font-medium">{{ $phone }}</p>
                        </div>
                    @endif
                    @if ($location)
                        <div class="border-l-2 border-gray-100 pl-6">
                            <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Location</p>
                            <p class="font-medium">{{ $location }}</p>
                        </div>
                    @endif
                </div>

                {{-- Form --}}
                <div class="lg:col-span-8">
                    <h2 class="section-title text-3xl mb-8">Send a Message</h2>
                    @if (session('contact_sent'))
                        <div class="bg-[#fafafa] border border-gray-200 p-4 text-sm mb-6">
                            Thank you! Your message has been sent. I'll get back to you soon.
                        </div>
                    @endif
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Name</label>
                                <input name="name" type="text" required value="{{ old('name') }}"
                                       class="w-full border-0 border-b border-gray-200 focus:border-accent bg-transparent py-3 text-sm outline-none transition-colors">
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Email</label>
                                <input name="email" type="email" required value="{{ old('email') }}"
                                       class="w-full border-0 border-b border-gray-200 focus:border-accent bg-transparent py-3 text-sm outline-none transition-colors">
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Subject</label>
                            <input name="subject" type="text" value="{{ old('subject') }}"
                                   class="w-full border-0 border-b border-gray-200 focus:border-accent bg-transparent py-3 text-sm outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Message</label>
                            <textarea name="message" rows="5" required
                                      class="w-full border-0 border-b border-gray-200 focus:border-accent bg-transparent py-3 text-sm outline-none transition-colors resize-none">{{ old('message') }}</textarea>
                            @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit"
                                class="bg-charcoal text-white px-10 py-4 font-medium text-sm uppercase tracking-widest hover:bg-accent transition-colors duration-300">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </section>

@include('partials.public-layout-end')
