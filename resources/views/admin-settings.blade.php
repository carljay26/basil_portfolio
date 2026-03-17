@include('partials.admin-layout', ['title' => 'Settings', 'active' => 'settings'])

    {{-- Page Header --}}
    <header class="bg-white px-8 py-5 flex justify-between items-center sticky top-0 z-10"
            style="border-bottom:1px solid #e8e6e1;">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Settings</h2>
            <p class="text-sm text-gray-400 mt-0.5">Account info and portfolio profile data.</p>
        </div>
        <a href="{{ url('/') }}" target="_blank"
           class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-600 bg-white transition-colors hover:bg-gray-50"
           style="border:1px solid #e8e6e1;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            View Site
        </a>
    </header>

    <div class="p-8 max-w-3xl mx-auto space-y-6">

        @if (session('settings_saved'))
            <div class="flex items-center gap-3 rounded-xl px-5 py-3.5 text-sm font-medium"
                 style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Settings saved successfully.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.save') }}" class="space-y-5">
            @csrf

            {{-- ── Personal Information ── --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #f0ede8;">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#1a1a1a;">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Personal Information</h3>
                        <p class="text-xs text-gray-400">Basic identity shown on your portfolio.</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Full Name</label>
                        <input name="name" value="{{ $profile->name ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. Juan dela Cruz">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Title / Role</label>
                        <input name="title" value="{{ $profile->title ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. UI/UX Designer">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Availability</label>
                        <input name="availability" value="{{ $profile->availability ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. Open to Work">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tagline</label>
                        <input name="tagline" value="{{ $profile->tagline ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="A compelling one-liner about you">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Bio</label>
                        <textarea name="bio" rows="4"
                                  class="w-full rounded-lg border text-sm px-3 py-2.5 resize-none"
                                  style="border-color:#e8e6e1;"
                                  placeholder="Tell visitors about yourself...">{{ $profile->bio ?? '' }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Favourite Quote</label>
                        <input name="quote" value="{{ $profile->quote ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. Design is thinking made visual.">
                    </div>
                </div>
            </section>

            {{-- ── Contact Information ── --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #f0ede8;">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#C5A059;">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Contact Information</h3>
                        <p class="text-xs text-gray-400">How visitors can reach you.</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email</label>
                        <input name="email" type="email" value="{{ $profile->email ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="you@example.com">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Phone</label>
                        <input name="phone" value="{{ $profile->phone ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="+63 9XX XXX XXXX">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Location</label>
                        <input name="location" value="{{ $profile->location ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. Cebu, Philippines">
                    </div>
                </div>
            </section>

            {{-- ── Social & Links ── --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #f0ede8;">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#1a1a1a;">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Social & Links</h3>
                        <p class="text-xs text-gray-400">Profile image, resume, and social media.</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Profile Photo URL</label>
                        <input name="profile_image_url" value="{{ $profile->profile_image_url ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Resume URL</label>
                        <input name="resume_url" value="{{ $profile->resume_url ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Gmail / Email Link</label>
                        <input name="gmail_url" value="{{ $profile->gmail_url ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="mailto:you@gmail.com">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Facebook URL</label>
                        <input name="facebook_url" value="{{ $profile->facebook_url ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="https://facebook.com/...">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Discord URL</label>
                        <input name="discord_url" value="{{ $profile->discord_url ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="https://discord.gg/...">
                    </div>
                </div>
            </section>

            {{-- ── Extra Details ── --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #f0ede8;">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#C5A059;">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Extra Details</h3>
                        <p class="text-xs text-gray-400">Stats and additional info.</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Experience (years)</label>
                        <input name="experience_years" type="number" min="0" value="{{ $profile->experience_years ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. 3">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Projects Count</label>
                        <input name="projects_count" type="number" min="0" value="{{ $profile->projects_count ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. 12">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Clients Count</label>
                        <input name="clients_count" type="number" min="0" value="{{ $profile->clients_count ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. 5">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Satisfaction Score</label>
                        <input name="satisfaction_score" value="{{ $profile->satisfaction_score ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. 4.9/5">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Languages</label>
                        <input name="languages" value="{{ $profile->languages ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. English, Filipino">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Current Engagement</label>
                        <input name="current_engagement" value="{{ $profile->current_engagement ?? '' }}"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;" placeholder="e.g. Freelance">
                    </div>
                </div>
            </section>

            {{-- ── Account Security ── --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #f0ede8;">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#1a1a1a;">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Account Security</h3>
                        <p class="text-xs text-gray-400">Change your admin login password.</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">New Password</label>
                        <input name="new_password" type="password"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;"
                               autocomplete="new-password"
                               placeholder="Leave blank to keep current">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Confirm New Password</label>
                        <input name="new_password_confirmation" type="password"
                               class="w-full rounded-lg border text-sm px-3 py-2.5"
                               style="border-color:#e8e6e1;"
                               autocomplete="new-password">
                    </div>
                </div>
            </section>

            <div class="flex justify-end pt-2 pb-8">
                <button type="submit"
                        class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                        style="background:#1a1a1a;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save All Settings
                </button>
            </div>
        </form>
    </div>

@include('partials.admin-layout-end')
