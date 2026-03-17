@include('partials.admin-layout', ['title' => 'Content', 'active' => 'content'])

    {{-- Page Header --}}
    <header class="bg-white px-8 py-5 flex justify-between items-center sticky top-0 z-10"
            style="border-bottom:1px solid #e8e6e1;">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Content</h2>
            <p class="text-sm text-gray-400 mt-0.5">Edit what appears on the public portfolio.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ url('/') }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-600 bg-white transition-colors hover:bg-gray-50"
               style="border:1px solid #e8e6e1;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                View Site
            </a>
            @if ($edit)
                <a href="{{ route('admin.content') }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-600 bg-white transition-colors hover:bg-gray-50"
                   style="border:1px solid #e8e6e1;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Lock
                </a>
            @else
                <a href="{{ route('admin.content', ['edit' => 1]) }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors"
                   style="background:#1a1a1a;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Mode
                </a>
            @endif
        </div>
    </header>

    <div class="p-8 max-w-7xl mx-auto space-y-8">

        {{-- Success notice --}}
        @if (session('saved'))
            <div class="flex items-center gap-3 rounded-xl px-5 py-3.5 text-sm font-medium"
                 style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Content saved. The public portfolio now reflects your changes.
            </div>
        @endif

        {{-- Edit-mode banner --}}
        @if (!$edit)
            <div class="flex items-center gap-3 rounded-xl px-5 py-3.5 text-sm"
                 style="background:#fffbf0; border:1px solid #fde68a; color:#92400e;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Content is <strong>locked</strong>. Click <strong>Edit Mode</strong> in the top-right to make changes.
            </div>
        @endif

        {{-- ──────────────────────────────────────────────
             SECTION 1 — Profile Information
        ─────────────────────────────────────────────── --}}
        <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div class="px-6 py-5 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#1a1a1a;">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Profile Information</h3>
                        <p class="text-xs text-gray-400">Name, title, tagline, bio, contact, and links.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.content.profile.save') }}" enctype="multipart/form-data"
                  class="p-6 {{ $edit ? '' : 'pointer-events-none opacity-60' }}">
                @csrf

                {{-- Profile Photo --}}
                <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400 mb-3">Profile Photo</p>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full overflow-hidden flex items-center justify-center"
                             style="background:#f5f4f0; border:1px solid #e8e6e1;">
                            @if (!empty($profile->profile_image_url))
                                <img src="{{ $profile->profile_image_url }}" alt="Current profile photo"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-semibold text-gray-400">
                                    {{ $profile->name ? strtoupper(substr($profile->name, 0, 2)) : 'PF' }}
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 space-y-1">
                            <p class="font-medium text-gray-700">Upload a new profile picture</p>
                            <p>JPG, PNG up to 4 MB.</p>
                        </div>
                    </div>
                    @if ($edit)
                        <div class="w-full sm:w-auto">
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Choose Image</label>
                            <input type="file" name="profile_image_file" accept="image/*"
                                   class="block w-full text-xs text-gray-500
                                          file:mr-3 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-xs file:font-medium
                                          file:bg-gray-900 file:text-white
                                          hover:file:bg-gray-800">
                        </div>
                    @endif
                </div>

                {{-- Identity --}}
                <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400 mb-3">Identity</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Full Name</label>
                        <input name="name" value="{{ $profile->name }}"
                               class="w-full rounded-lg border text-sm px-3 py-2 focus:outline-none focus:ring-2"
                               style="border-color:#e8e6e1; focus:ring-color:#C5A059;">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Title / Role</label>
                        <input name="title" value="{{ $profile->title }}"
                               class="w-full rounded-lg border text-sm px-3 py-2 focus:outline-none focus:ring-2"
                               style="border-color:#e8e6e1;"
                               placeholder="e.g. UI/UX Designer">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Availability</label>
                        <input name="availability" value="{{ $profile->availability }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;"
                               placeholder="e.g. Open to Work">
                    </div>
                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Tagline</label>
                        <input name="tagline" value="{{ $profile->tagline }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;"
                               placeholder="Short compelling headline for the hero section">
                    </div>
                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Bio (About Me)</label>
                        <textarea name="bio" rows="4"
                                  class="w-full rounded-lg border text-sm px-3 py-2 resize-none"
                                  style="border-color:#e8e6e1;">{{ $profile->bio }}</textarea>
                    </div>
                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Favourite Quote</label>
                        <input name="quote" value="{{ $profile->quote }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;">
                    </div>
                </div>

                {{-- Stats --}}
                <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400 mb-3">Stats (shown on hero)</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Experience (years)</label>
                        <input name="experience_years" type="number" min="0" value="{{ $profile->experience_years }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="e.g. 3">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Projects Count</label>
                        <input name="projects_count" type="number" min="0" value="{{ $profile->projects_count }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="e.g. 12">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Clients Count</label>
                        <input name="clients_count" type="number" min="0" value="{{ $profile->clients_count }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="e.g. 5">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Satisfaction Score</label>
                        <input name="satisfaction_score" value="{{ $profile->satisfaction_score }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="e.g. 4.9/5">
                    </div>
                </div>

                {{-- Contact --}}
                <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400 mb-3">Contact</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Email</label>
                        <input name="email" value="{{ $profile->email }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Phone</label>
                        <input name="phone" value="{{ $profile->phone }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Location</label>
                        <input name="location" value="{{ $profile->location }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;">
                    </div>
                </div>

                {{-- Links & Media --}}
                <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400 mb-3">Links & Media</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Profile Photo URL</label>
                        <input name="profile_image_url" value="{{ $profile->profile_image_url }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Resume URL</label>
                        <input name="resume_url" value="{{ $profile->resume_url }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Gmail / Email Link</label>
                        <input name="gmail_url" value="{{ $profile->gmail_url }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="mailto:you@example.com">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Facebook URL</label>
                        <input name="facebook_url" value="{{ $profile->facebook_url }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="https://facebook.com/...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Discord URL</label>
                        <input name="discord_url" value="{{ $profile->discord_url }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="https://discord.gg/...">
                    </div>
                </div>

                {{-- Extra --}}
                <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400 mb-3">Extra Details</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Languages</label>
                        <input name="languages" value="{{ $profile->languages }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="e.g. English, Filipino">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Current Engagement</label>
                        <input name="current_engagement" value="{{ $profile->current_engagement }}"
                               class="w-full rounded-lg border text-sm px-3 py-2"
                               style="border-color:#e8e6e1;" placeholder="e.g. Freelance">
                    </div>
                </div>

                @if ($edit)
                    <div class="flex justify-end pt-2">
                        <button type="submit"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium text-white transition-colors"
                                style="background:#1a1a1a;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Profile
                        </button>
                    </div>
                @endif
            </form>
        </section>

        {{-- ──────────────────────────────────────────────
             SECTION 2 — Skills & Tools (2-col)
        ─────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Skills --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-5 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-md flex items-center justify-center" style="background:#C5A059;">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Skills / Expertise</h3>
                            <p class="text-xs text-gray-400">Shown in the Expertise section.</p>
                        </div>
                    </div>
                    @if ($edit)
                        <button type="button" data-open-dialog="skillDialog"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-white transition-colors"
                                style="background:#1a1a1a;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Skill
                        </button>
                    @endif
                </div>
                <div class="p-5">
                    @if ($skills->count() === 0)
                        <p class="text-sm text-gray-400 text-center py-6">No skills added yet.</p>
                    @else
                        <div class="flex flex-wrap gap-2">
                            @foreach ($skills as $skill)
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium"
                                      style="background:#f5f4f0; border:1px solid #e8e6e1; color:#1a1a1a;">
                                    {{ $skill->name }}
                                    @if ($skill->category)
                                        <span class="text-gray-400">· {{ $skill->category }}</span>
                                    @endif
                                    @if ($edit)
                                        <form method="POST" action="{{ route('admin.content.skill.delete', ['id' => $skill->id]) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="w-4 h-4 rounded-full text-gray-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors"
                                                    title="Remove">×</button>
                                        </form>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            {{-- Tools --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-5 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-md flex items-center justify-center" style="background:#C5A059;">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Tools</h3>
                            <p class="text-xs text-gray-400">Figma, VS Code, Canva, etc.</p>
                        </div>
                    </div>
                    @if ($edit)
                        <button type="button" data-open-dialog="toolDialog"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-white transition-colors"
                                style="background:#1a1a1a;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Tool
                        </button>
                    @endif
                </div>
                <div class="p-5">
                    @if ($tools->count() === 0)
                        <p class="text-sm text-gray-400 text-center py-6">No tools added yet.</p>
                    @else
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tools as $tool)
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium"
                                      style="background:#f5f4f0; border:1px solid #e8e6e1; color:#1a1a1a;">
                                    {{ $tool->name }}
                                    @if ($tool->category)
                                        <span class="text-gray-400">· {{ $tool->category }}</span>
                                    @endif
                                    @if ($edit)
                                        <form method="POST" action="{{ route('admin.content.tool.delete', ['id' => $tool->id]) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="w-4 h-4 rounded-full text-gray-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors"
                                                    title="Remove">×</button>
                                        </form>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>

        {{-- ──────────────────────────────────────────────
             SECTION 3 — Experience, Clients, Reviews
        ─────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Experience --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Experience</h3>
                        <p class="text-xs text-gray-400">Work history & roles.</p>
                    </div>
                    @if ($edit)
                        <button type="button" data-open-dialog="experienceDialog"
                                class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-white"
                                style="background:#1a1a1a;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add
                        </button>
                    @endif
                </div>
                <div class="p-4 space-y-3 max-h-[520px] overflow-y-auto">
                    @if ($experiences->count() === 0)
                        <p class="text-sm text-gray-400 text-center py-8">No experience entries yet.</p>
                    @else
                        @foreach ($experiences as $exp)
                            <div class="p-4 rounded-xl" style="background:#f8f7f5; border:1px solid #f0ede8;">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $exp->title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 truncate">
                                            {{ $exp->company ?: '—' }}
                                            @if ($exp->role)
                                                <span style="color:#C5A059;">·</span> {{ $exp->role }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ $exp->start_date ?: '?' }} –
                                            {{ $exp->is_current ? 'Present' : ($exp->end_date ?: '?') }}
                                        </p>
                                    </div>
                                    @if ($exp->is_current)
                                        <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-full"
                                              style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                                            Current
                                        </span>
                                    @endif
                                </div>
                                @if ($exp->description)
                                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $exp->description }}</p>
                                @endif
                                @if ($edit)
                                    <div class="flex gap-2 mt-3">
                                        <button type="button"
                                                class="flex-1 py-1.5 rounded-lg text-xs font-medium text-gray-600 transition-colors hover:bg-white"
                                                style="background:#ede9e3; border:1px solid #e8e6e1;"
                                                data-open-dialog="experienceEditDialog"
                                                data-exp-id="{{ $exp->id }}"
                                                data-exp-title="{{ e($exp->title) }}"
                                                data-exp-company="{{ e($exp->company) }}"
                                                data-exp-role="{{ e($exp->role) }}"
                                                data-exp-description="{{ e($exp->description) }}"
                                                data-exp-start="{{ e($exp->start_date) }}"
                                                data-exp-end="{{ e($exp->end_date) }}"
                                                data-exp-current="{{ $exp->is_current ? '1' : '0' }}">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.content.experience.delete', ['id' => $exp->id]) }}" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full py-1.5 rounded-lg text-xs font-medium text-red-600 transition-colors hover:bg-red-50"
                                                    style="border:1px solid #fecaca;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>

            {{-- Clients --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Clients</h3>
                        <p class="text-xs text-gray-400">Shown on landing page.</p>
                    </div>
                    @if ($edit)
                        <button type="button" data-open-dialog="clientDialog"
                                class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-white"
                                style="background:#1a1a1a;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add
                        </button>
                    @endif
                </div>
                <div class="p-4 space-y-3 max-h-[520px] overflow-y-auto">
                    @if ($clients->count() === 0)
                        <p class="text-sm text-gray-400 text-center py-8">No clients added yet.</p>
                    @else
                        @foreach ($clients as $c)
                            <div class="flex items-center gap-3 p-3 rounded-xl" style="background:#f8f7f5; border:1px solid #f0ede8;">
                                <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 flex items-center justify-center"
                                     style="background:#e8e6e1;">
                                    @if ($c->logo_url)
                                        <img src="{{ $c->logo_url }}" alt="{{ $c->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs font-bold text-gray-400">
                                            {{ strtoupper(substr($c->name, 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $c->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $c->website_url ?: 'No website' }}</p>
                                </div>
                                @if ($edit)
                                    <div class="flex gap-1 shrink-0">
                                        <button type="button"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-white transition-colors"
                                                data-open-dialog="clientEditDialog"
                                                data-client-id="{{ $c->id }}"
                                                data-client-name="{{ e($c->name) }}"
                                                data-client-logo="{{ e($c->logo_url) }}"
                                                data-client-website="{{ e($c->website_url) }}"
                                                title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.content.client.delete', ['id' => $c->id]) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                                    title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>

            {{-- Reviews / Satisfaction --}}
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Satisfaction</h3>
                        <p class="text-xs text-gray-400">Reviews & testimonials.</p>
                    </div>
                    @if ($edit)
                        <button type="button" data-open-dialog="satisfactionDialog"
                                class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-white"
                                style="background:#1a1a1a;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add
                        </button>
                    @endif
                </div>
                <div class="p-4 space-y-3 max-h-[520px] overflow-y-auto">
                    @if ($satisfactions->count() === 0)
                        <p class="text-sm text-gray-400 text-center py-8">No reviews added yet.</p>
                    @else
                        @foreach ($satisfactions as $s)
                            <div class="p-4 rounded-xl" style="background:#f8f7f5; border:1px solid #f0ede8;">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $s->author_name }}</p>
                                        @if ($s->author_role)
                                            <p class="text-xs text-gray-400 truncate">{{ $s->author_role }}</p>
                                        @endif
                                    </div>
                                    @if ($s->rating)
                                        <div class="flex gap-0.5 shrink-0">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-3.5 h-3.5" fill="{{ $i <= $s->rating ? '#C5A059' : 'none' }}"
                                                     stroke="{{ $i <= $s->rating ? '#C5A059' : '#d1d5db' }}" viewBox="0 0 24 24">
                                                    <path stroke-linejoin="round" stroke-width="1.5"
                                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600 line-clamp-3">{{ $s->content }}</p>
                                @if ($edit)
                                    <div class="flex gap-2 mt-3">
                                        <button type="button"
                                                class="flex-1 py-1.5 rounded-lg text-xs font-medium text-gray-600 transition-colors hover:bg-white"
                                                style="background:#ede9e3; border:1px solid #e8e6e1;"
                                                data-open-dialog="satisfactionEditDialog"
                                                data-sat-id="{{ $s->id }}"
                                                data-sat-name="{{ e($s->author_name) }}"
                                                data-sat-role="{{ e($s->author_role) }}"
                                                data-sat-content="{{ e($s->content) }}"
                                                data-sat-rating="{{ e($s->rating) }}">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.content.satisfaction.delete', ['id' => $s->id]) }}" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full py-1.5 rounded-lg text-xs font-medium text-red-600 transition-colors hover:bg-red-50"
                                                    style="border:1px solid #fecaca;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </div>

        <div class="pb-8 text-center text-xs text-gray-400">
            Portfolio Admin &copy; {{ date('Y') }} · Content changes reflect on the public site instantly.
        </div>
    </div>

{{-- ══════════════════════════════════════════════════
     MODALS (inside body, before layout-end)
══════════════════════════════════════════════════ --}}

@php
function adminInput($name, $label, $placeholder = '', $type = 'text', $required = false) {
    return '';
}
@endphp

{{-- ── Skill Add ── --}}
<dialog id="skillDialog" class="rounded-2xl p-0 w-full max-w-md">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-md flex items-center justify-center" style="background:#C5A059;">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <h4 class="text-base font-semibold text-gray-900">Add Skill</h4>
        </div>
        <button type="button" data-close-dialog
                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.content.skill.add') }}" class="p-5 space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Skill Name <span class="text-red-500">*</span></label>
            <input name="name" class="w-full rounded-lg border text-sm px-3 py-2.5 focus:outline-none"
                   style="border-color:#e8e6e1;" placeholder="e.g. UI/UX Design" required>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Category <span class="text-gray-400 font-normal">(optional)</span></label>
            <input name="category" class="w-full rounded-lg border text-sm px-3 py-2.5"
                   style="border-color:#e8e6e1;" placeholder="e.g. Design, Development">
        </div>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog
                    class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 transition-colors hover:bg-gray-50"
                    style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit"
                    class="px-5 py-2.5 rounded-lg text-sm font-medium text-white transition-colors"
                    style="background:#1a1a1a;">Add Skill</button>
        </div>
    </form>
</dialog>

{{-- ── Tool Add ── --}}
<dialog id="toolDialog" class="rounded-2xl p-0 w-full max-w-md">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-md flex items-center justify-center" style="background:#C5A059;">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <h4 class="text-base font-semibold text-gray-900">Add Tool</h4>
        </div>
        <button type="button" data-close-dialog
                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.content.tool.add') }}" class="p-5 space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tool Name <span class="text-red-500">*</span></label>
            <input name="name" class="w-full rounded-lg border text-sm px-3 py-2.5"
                   style="border-color:#e8e6e1;" placeholder="e.g. Figma" required>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Category <span class="text-gray-400 font-normal">(optional)</span></label>
            <input name="category" class="w-full rounded-lg border text-sm px-3 py-2.5"
                   style="border-color:#e8e6e1;" placeholder="e.g. Design, Development">
        </div>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog
                    class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 transition-colors hover:bg-gray-50"
                    style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit"
                    class="px-5 py-2.5 rounded-lg text-sm font-medium text-white transition-colors"
                    style="background:#1a1a1a;">Add Tool</button>
        </div>
    </form>
</dialog>

{{-- ── Experience Add ── --}}
<dialog id="experienceDialog" class="rounded-2xl p-0 w-full max-w-lg">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <h4 class="text-base font-semibold text-gray-900">Add Experience</h4>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.content.experience.add') }}" class="p-5 space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Job Title <span class="text-red-500">*</span></label>
            <input name="title" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" required placeholder="e.g. Frontend Developer">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Company</label>
                <input name="company" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="e.g. Acme Corp">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Role Type</label>
                <input name="role" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="e.g. Full-time">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Start Date</label>
                <input name="start_date" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="e.g. Jan 2023">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">End Date</label>
                <input name="end_date" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="e.g. Dec 2024">
            </div>
        </div>
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
            <input name="is_current" type="checkbox" class="w-4 h-4 rounded" style="accent-color:#C5A059;">
            <span>Currently working here</span>
        </label>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Description</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border text-sm px-3 py-2.5 resize-none" style="border-color:#e8e6e1;" placeholder="Briefly describe your role and achievements..."></textarea>
        </div>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50" style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background:#1a1a1a;">Add Experience</button>
        </div>
    </form>
</dialog>

{{-- ── Experience Edit ── --}}
<dialog id="experienceEditDialog" class="rounded-2xl p-0 w-full max-w-lg">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <h4 class="text-base font-semibold text-gray-900">Edit Experience</h4>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" data-dynamic-action="experience" class="p-5 space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Job Title <span class="text-red-500">*</span></label>
            <input name="title" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" required>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Company</label>
                <input name="company" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Role Type</label>
                <input name="role" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Start Date</label>
                <input name="start_date" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">End Date</label>
                <input name="end_date" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
            </div>
        </div>
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
            <input name="is_current" type="checkbox" class="w-4 h-4 rounded" style="accent-color:#C5A059;">
            <span>Currently working here</span>
        </label>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Description</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border text-sm px-3 py-2.5 resize-none" style="border-color:#e8e6e1;"></textarea>
        </div>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50" style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background:#1a1a1a;">Save Changes</button>
        </div>
    </form>
</dialog>

{{-- ── Client Add ── --}}
<dialog id="clientDialog" class="rounded-2xl p-0 w-full max-w-md">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <h4 class="text-base font-semibold text-gray-900">Add Client</h4>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.content.client.add') }}" class="p-5 space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Client Name <span class="text-red-500">*</span></label>
            <input name="name" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" required placeholder="e.g. Acme Corp">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Logo URL <span class="text-gray-400 font-normal">(optional)</span></label>
            <input name="logo_url" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="https://...">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Website URL <span class="text-gray-400 font-normal">(optional)</span></label>
            <input name="website_url" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="https://...">
        </div>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50" style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background:#1a1a1a;">Add Client</button>
        </div>
    </form>
</dialog>

{{-- ── Client Edit ── --}}
<dialog id="clientEditDialog" class="rounded-2xl p-0 w-full max-w-md">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <h4 class="text-base font-semibold text-gray-900">Edit Client</h4>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" data-dynamic-action="client" class="p-5 space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Client Name <span class="text-red-500">*</span></label>
            <input name="name" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" required>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Logo URL</label>
            <input name="logo_url" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Website URL</label>
            <input name="website_url" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
        </div>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50" style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background:#1a1a1a;">Save Changes</button>
        </div>
    </form>
</dialog>

{{-- ── Satisfaction Add ── --}}
<dialog id="satisfactionDialog" class="rounded-2xl p-0 w-full max-w-md">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <h4 class="text-base font-semibold text-gray-900">Add Review</h4>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.content.satisfaction.add') }}" class="p-5 space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Author Name <span class="text-red-500">*</span></label>
                <input name="author_name" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Author Role</label>
                <input name="author_role" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="e.g. CEO at Acme">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Review Content <span class="text-red-500">*</span></label>
            <textarea name="content" rows="4" class="w-full rounded-lg border text-sm px-3 py-2.5 resize-none" style="border-color:#e8e6e1;" required></textarea>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Rating (1–5)</label>
            <div class="flex gap-3">
                @for ($i = 1; $i <= 5; $i++)
                    <label class="flex items-center gap-1 text-sm cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="w-4 h-4" style="accent-color:#C5A059;">
                        <span class="text-gray-600">{{ $i }}</span>
                    </label>
                @endfor
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50" style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background:#1a1a1a;">Add Review</button>
        </div>
    </form>
</dialog>

{{-- ── Satisfaction Edit ── --}}
<dialog id="satisfactionEditDialog" class="rounded-2xl p-0 w-full max-w-md">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <h4 class="text-base font-semibold text-gray-900">Edit Review</h4>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" data-dynamic-action="satisfaction" class="p-5 space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Author Name <span class="text-red-500">*</span></label>
                <input name="author_name" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Author Role</label>
                <input name="author_role" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Review Content <span class="text-red-500">*</span></label>
            <textarea name="content" rows="4" class="w-full rounded-lg border text-sm px-3 py-2.5 resize-none" style="border-color:#e8e6e1;" required></textarea>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Rating (1–5)</label>
            <div class="flex gap-3">
                @for ($i = 1; $i <= 5; $i++)
                    <label class="flex items-center gap-1 text-sm cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="w-4 h-4" style="accent-color:#C5A059;">
                        <span class="text-gray-600">{{ $i }}</span>
                    </label>
                @endfor
            </div>
        </div>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50" style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background:#1a1a1a;">Save Changes</button>
        </div>
    </form>
</dialog>

<script>
document.addEventListener('click', e => {
    const openBtn = e.target.closest('[data-open-dialog]');
    if (openBtn) {
        const id   = openBtn.dataset.openDialog;
        const dlg  = document.getElementById(id);
        if (!dlg) return;

        if (id === 'experienceEditDialog') {
            const form = dlg.querySelector('form');
            form.action = `/admin/content/experience/${openBtn.dataset.expId}`;
            form.querySelector('[name="title"]').value       = openBtn.dataset.expTitle       ?? '';
            form.querySelector('[name="company"]').value     = openBtn.dataset.expCompany     ?? '';
            form.querySelector('[name="role"]').value        = openBtn.dataset.expRole        ?? '';
            form.querySelector('[name="description"]').value = openBtn.dataset.expDescription ?? '';
            form.querySelector('[name="start_date"]').value  = openBtn.dataset.expStart       ?? '';
            form.querySelector('[name="end_date"]').value    = openBtn.dataset.expEnd         ?? '';
            form.querySelector('[name="is_current"]').checked = (openBtn.dataset.expCurrent ?? '0') === '1';
        }

        if (id === 'clientEditDialog') {
            const form = dlg.querySelector('form');
            form.action = `/admin/content/client/${openBtn.dataset.clientId}`;
            form.querySelector('[name="name"]').value        = openBtn.dataset.clientName    ?? '';
            form.querySelector('[name="logo_url"]').value    = openBtn.dataset.clientLogo    ?? '';
            form.querySelector('[name="website_url"]').value = openBtn.dataset.clientWebsite ?? '';
        }

        if (id === 'satisfactionEditDialog') {
            const form = dlg.querySelector('form');
            form.action = `/admin/content/satisfaction/${openBtn.dataset.satId}`;
            form.querySelector('[name="author_name"]').value  = openBtn.dataset.satName    ?? '';
            form.querySelector('[name="author_role"]').value  = openBtn.dataset.satRole    ?? '';
            form.querySelector('[name="content"]').value      = openBtn.dataset.satContent ?? '';
            const rating = parseInt(openBtn.dataset.satRating ?? '0');
            form.querySelectorAll('[name="rating"]').forEach(r => {
                r.checked = parseInt(r.value) === rating;
            });
        }

        dlg.showModal?.();
    }

    const closeBtn = e.target.closest('[data-close-dialog]');
    if (closeBtn) {
        closeBtn.closest('dialog')?.close();
    }
});
</script>

@include('partials.admin-layout-end')
