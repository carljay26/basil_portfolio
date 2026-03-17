@include('partials.admin-layout', ['title' => 'Dashboard', 'active' => 'dashboard'])

    {{-- Page Header --}}
    <header class="bg-white px-8 py-5 flex justify-between items-center sticky top-0 z-10"
            style="border-bottom:1px solid #e8e6e1;">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Dashboard</h2>
            <p class="text-sm text-gray-400 mt-0.5">Portfolio overview and analytics.</p>
        </div>
        <a href="{{ url('/') }}" target="_blank"
           class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-600 bg-white transition-colors hover:bg-gray-50"
           style="border:1px solid #e8e6e1;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            View Public Site
        </a>
    </header>

    <div class="p-8 max-w-7xl mx-auto space-y-8">

        {{-- ── Stat Cards ── --}}
        <section class="grid grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Profile Views --}}
            <div class="bg-white rounded-2xl p-6" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Profile Views</p>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:#f5f4f0;">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($trafficTotals['page_views'] ?? 0) }}</p>
                <p class="text-xs text-gray-400 mt-1">Total all time</p>
            </div>

            {{-- Clicks --}}
            <div class="bg-white rounded-2xl p-6" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Clicks</p>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:#f5f4f0;">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($trafficTotals['clicks'] ?? 0) }}</p>
                <p class="text-xs text-gray-400 mt-1">Total all time</p>
            </div>

            {{-- Messages --}}
            <div class="rounded-2xl p-6" style="background:#1a1a1a; border:1px solid #1a1a1a; box-shadow:0 1px 4px rgba(0,0,0,.08);">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] font-bold uppercase tracking-wider" style="color:rgba(255,255,255,.5);">Messages</p>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(255,255,255,.08);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-white">{{ number_format($messagesTotal ?? 0) }}</p>
                <p class="text-xs mt-1" style="color:#C5A059;">{{ $messagesUnread ?? 0 }} unread</p>
            </div>

            {{-- Active Projects --}}
            <div class="rounded-2xl p-6" style="background:#C5A059; box-shadow:0 1px 4px rgba(0,0,0,.08);">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-white/70">Projects</p>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(255,255,255,.2);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-white">{{ number_format($activeProjectsCount ?? 0) }}</p>
                <p class="text-xs text-white/70 mt-1">Active & published</p>
            </div>
        </section>

        {{-- ── Traffic Chart / Table ── --}}
        <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div class="px-6 py-5 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Site Traffic</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Page views, clicks & resume downloads.</p>
                </div>
                <div class="flex gap-1.5">
                    <a href="{{ route('admin.dashboard', ['range' => '7d']) }}"
                       class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-colors"
                       style="{{ ($range ?? '7d') === '7d' ? 'background:#1a1a1a; color:white;' : 'background:#f5f4f0; color:#6b7280;' }}">
                        7 days
                    </a>
                    <a href="{{ route('admin.dashboard', ['range' => '30d']) }}"
                       class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-colors"
                       style="{{ ($range ?? '7d') === '30d' ? 'background:#1a1a1a; color:white;' : 'background:#f5f4f0; color:#6b7280;' }}">
                        30 days
                    </a>
                </div>
            </div>

            @if (($traffic ?? collect())->count() === 0)
                <div class="py-16 text-center">
                    <p class="text-sm text-gray-400">No traffic data for this period.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead style="background:#f8f7f5;">
                        <tr>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Views</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Clicks</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Resume DL</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($traffic as $row)
                            <tr class="hover:bg-amber-50/30 transition-colors" style="border-top:1px solid #f5f4f0;">
                                <td class="px-6 py-3.5 text-sm text-gray-700 font-medium">{{ $row->view_date }}</td>
                                <td class="px-6 py-3.5 text-sm font-semibold text-gray-900">{{ $row->page_views ?? 0 }}</td>
                                <td class="px-6 py-3.5 text-sm font-semibold text-gray-900">{{ $row->clicks ?? 0 }}</td>
                                <td class="px-6 py-3.5 text-sm font-semibold text-gray-900">{{ $row->resume_downloads ?? 0 }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ── Recent Messages ── --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-5 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Recent Messages</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Latest contact form inquiries.</p>
                    </div>
                    <a href="{{ route('admin.messages') }}"
                       class="text-xs font-semibold transition-colors hover:opacity-70"
                       style="color:#C5A059;">View all →</a>
                </div>
                @if (($recentMessages ?? collect())->count() === 0)
                    <div class="py-12 text-center">
                        <p class="text-sm text-gray-400">No messages yet.</p>
                    </div>
                @else
                    <div>
                        @foreach ($recentMessages as $m)
                            <div class="px-6 py-4 flex items-start gap-3 transition-colors hover:bg-amber-50/20"
                                 style="border-top:1px solid #f5f4f0;">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0"
                                     style="{{ !$m->is_read ? 'background:#1a1a1a; color:#C5A059;' : 'background:#f5f4f0; color:#9ca3af;' }}">
                                    {{ strtoupper(substr($m->name ?: '?', 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $m->name }}</p>
                                        @if (!$m->is_read)
                                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full text-white"
                                                  style="background:#1a1a1a;">NEW</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ $m->message }}</p>
                                </div>
                                <p class="text-xs text-gray-400 shrink-0">
                                    {{ \Carbon\Carbon::parse($m->created_at)->diffForHumans(null, true) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- ── Active Projects ── --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-5 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Active Projects</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Draft and published projects.</p>
                    </div>
                    <a href="{{ route('admin.projects') }}"
                       class="text-xs font-semibold transition-colors hover:opacity-70"
                       style="color:#C5A059;">Manage →</a>
                </div>
                @if (($activeProjects ?? collect())->count() === 0)
                    <div class="py-12 text-center">
                        <p class="text-sm text-gray-400 mb-4">No projects added yet.</p>
                        <a href="{{ route('admin.projects') }}"
                           class="px-4 py-2 rounded-lg text-xs font-semibold text-white"
                           style="background:#1a1a1a;">Add Project</a>
                    </div>
                @else
                    <div>
                        @foreach ($activeProjects as $p)
                            <div class="px-6 py-4 flex items-center gap-4 transition-colors hover:bg-amber-50/20"
                                 style="border-top:1px solid #f5f4f0;">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $p->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->client_name ?: '—' }}</p>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    @if ($p->featured)
                                        <svg class="w-3.5 h-3.5" fill="#C5A059" viewBox="0 0 24 24">
                                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    @endif
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full"
                                          style="{{ $p->status === 'published'
                                                    ? 'background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;'
                                                    : 'background:#fffbf0; color:#92400e; border:1px solid #fde68a;' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        <footer class="pb-8 text-center text-xs text-gray-400">
            Portfolio Admin &copy; {{ date('Y') }} · Basil Mohsin E. Fulgencio
        </footer>
    </div>

@include('partials.admin-layout-end')
