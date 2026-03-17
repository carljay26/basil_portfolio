    </main>

    {{-- Footer --}}
    <footer class="bg-charcoal text-white py-16 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <p class="text-xl font-bold tracking-tighter mb-2">{{ $pubFullName }}</p>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $pubProfile?->tagline ?: 'Building digital experiences.' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500 mb-3">Navigate</p>
                <ul class="space-y-1.5 text-sm text-gray-400">
                    @foreach ($navLinks as $nl)
                        <li><a href="{{ $nl['href'] }}" class="hover:text-white transition-colors">{{ $nl['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500 mb-3">Contact</p>
                <ul class="space-y-1.5 text-sm text-gray-400">
                    @if ($pubEmail && $pubEmail !== 'N/A')
                        <li><a href="mailto:{{ $pubEmail }}" class="hover:text-white transition-colors">{{ $pubEmail }}</a></li>
                    @endif
                    @if ($pubPhone)
                        <li><span>{{ $pubPhone }}</span></li>
                    @endif
                    @if ($pubLocation)
                        <li><span>{{ $pubLocation }}</span></li>
                    @endif
                </ul>
                <div class="flex gap-3 mt-4">
                    @if ($pubDiscord)
                        <a href="{{ $pubDiscord }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition-colors" title="Discord">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057c.002.022.015.043.031.056a19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 00-.041-.106 13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03z"/></svg>
                        </a>
                    @endif
                    @if ($pubGmail)
                        <a href="{{ $pubGmail }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition-colors" title="Gmail">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 010 19.366V5.457c0-.904.732-1.636 1.636-1.636H3.82l8.18 6.136 8.182-6.136h2.182c.904 0 1.636.732 1.636 1.636z"/></svg>
                        </a>
                    @endif
                    @if ($pubFacebook)
                        <a href="{{ $pubFacebook }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition-colors" title="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-10 pt-6 border-t border-gray-800 text-xs text-gray-600 text-center">
            &copy; {{ date('Y') }} {{ $pubFullName }}. All rights reserved.
        </div>
    </footer>

    <script>
        const menuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        }
    </script>
</body>
</html>
