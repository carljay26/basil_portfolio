@include('partials.admin-layout', ['title' => 'Projects', 'active' => 'projects'])

    {{-- Page Header --}}
    <header class="bg-white px-8 py-5 flex justify-between items-center sticky top-0 z-10"
            style="border-bottom:1px solid #e8e6e1;">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Projects</h2>
            <p class="text-sm text-gray-400 mt-0.5">Manage your portfolio projects.</p>
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
            <button type="button" data-open-dialog="projectAddDialog"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors"
                    style="background:#1a1a1a;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Project
            </button>
        </div>
    </header>

    <div class="p-8 max-w-7xl mx-auto space-y-6">

        {{-- Flash messages --}}
        @if (session('project_saved'))
            <div class="flex items-center gap-3 rounded-xl px-5 py-3.5 text-sm font-medium"
                 style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Project saved successfully.
            </div>
        @endif
        @if (session('archived_cleared'))
            <div class="flex items-center gap-3 rounded-xl px-5 py-3.5 text-sm font-medium"
                 style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Archived projects cleared.
            </div>
        @endif

        {{-- Tabs --}}
        @php $tab = request('tab', 'active'); @endphp
        <div class="flex gap-1" style="border-bottom:1px solid #e8e6e1;">
            <a href="{{ route('admin.projects', ['tab' => 'active']) }}"
               class="px-5 py-2.5 text-sm font-medium transition-colors -mb-px
                      {{ $tab === 'active' ? 'text-gray-900 border-b-2 border-charcoal' : 'text-gray-400 hover:text-gray-600' }}"
               style="{{ $tab === 'active' ? 'border-bottom:2px solid #1a1a1a;' : '' }}">
                Active
                <span class="ml-1.5 text-xs rounded-full px-2 py-0.5 font-semibold"
                      style="{{ $tab === 'active' ? 'background:#1a1a1a; color:white;' : 'background:#f0ede8; color:#6b7280;' }}">
                    {{ $activeProjects->count() }}
                </span>
            </a>
            <a href="{{ route('admin.projects', ['tab' => 'archived']) }}"
               class="px-5 py-2.5 text-sm font-medium transition-colors -mb-px
                      {{ $tab === 'archived' ? 'text-gray-900' : 'text-gray-400 hover:text-gray-600' }}"
               style="{{ $tab === 'archived' ? 'border-bottom:2px solid #1a1a1a;' : '' }}">
                Archived
                <span class="ml-1.5 text-xs rounded-full px-2 py-0.5 font-semibold"
                      style="{{ $tab === 'archived' ? 'background:#1a1a1a; color:white;' : 'background:#f0ede8; color:#6b7280;' }}">
                    {{ $archivedProjects->count() }}
                </span>
            </a>
        </div>

        {{-- Active Projects --}}
        @if ($tab === 'active')
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                @if ($activeProjects->count() === 0)
                    <div class="py-20 text-center">
                        <div class="w-12 h-12 rounded-xl mx-auto mb-4 flex items-center justify-center" style="background:#f5f4f0;">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">No projects yet</p>
                        <p class="text-xs text-gray-400 mb-5">Add your first portfolio project to get started.</p>
                        <button type="button" data-open-dialog="projectAddDialog"
                                class="px-5 py-2.5 rounded-lg text-sm font-medium text-white transition-colors"
                                style="background:#1a1a1a;">
                            Add First Project
                        </button>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead style="background:#f8f7f5; border-bottom:1px solid #e8e6e1;">
                            <tr>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Featured</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Updated</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($activeProjects as $p)
                                <tr class="transition-colors hover:bg-amber-50/30" style="border-bottom:1px solid #f5f4f0;">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-900">{{ $p->title }}</p>
                                        @if ($p->subtitle)
                                            <p class="text-xs text-gray-400 mt-0.5 truncate max-w-[200px]">{{ $p->subtitle }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $p->client_name ?: '—' }}</td>
                                    <td class="px-6 py-4">
                                        @if ($p->status === 'published')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                                  style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                                  style="background:#fffbf0; color:#92400e; border:1px solid #fde68a;">
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($p->featured)
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold" style="color:#C5A059;">
                                                <svg class="w-3.5 h-3.5" fill="#C5A059" viewBox="0 0 24 24">
                                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                                Featured
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($p->updated_at)->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1">
                                            <button type="button"
                                                    data-open-dialog="projectEditDialog"
                                                    data-id="{{ $p->id }}"
                                                    data-title="{{ e($p->title) }}"
                                                    data-subtitle="{{ e($p->subtitle) }}"
                                                    data-client="{{ e($p->client_name) }}"
                                                    data-status="{{ $p->status }}"
                                                    data-summary="{{ e($p->summary) }}"
                                                    data-thumbnail="{{ e($p->thumbnail_url) }}"
                                                    data-featured="{{ $p->featured ? '1' : '0' }}"
                                                    class="p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors"
                                                    title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </button>
                                            <form method="POST" action="{{ route('admin.projects.archive', $p->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-colors" title="Archive">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                              d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        @endif

        {{-- Archived Projects --}}
        @if ($tab === 'archived')
            <section class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e8e6e1; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid #f0ede8;">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Archived Projects</h3>
                        <p class="text-xs text-gray-400">{{ $archivedProjects->count() }} archived. Restore or delete permanently.</p>
                    </div>
                    @if ($archivedProjects->count() > 0)
                        <form method="POST" action="{{ route('admin.projects.clear-archived') }}"
                              onsubmit="return confirm('Permanently delete all archived projects?')">
                            @csrf
                            <button type="submit"
                                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-red-600 transition-colors hover:bg-red-50"
                                    style="border:1px solid #fecaca;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Clear All
                            </button>
                        </form>
                    @endif
                </div>
                @if ($archivedProjects->count() === 0)
                    <div class="py-16 text-center">
                        <p class="text-sm text-gray-400">No archived projects.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead style="background:#f8f7f5; border-bottom:1px solid #e8e6e1;">
                            <tr>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Updated</th>
                                <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($archivedProjects as $p)
                                <tr class="hover:bg-gray-50 transition-colors" style="border-bottom:1px solid #f5f4f0;">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-900">{{ $p->title }}</p>
                                        <p class="text-xs text-gray-400">{{ $p->subtitle ?: '—' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $p->client_name ?: '—' }}</td>
                                    <td class="px-6 py-4 text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($p->updated_at)->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1">
                                            <form method="POST" action="{{ route('admin.projects.restore', $p->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition-colors" title="Restore">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.projects.delete', $p->id) }}" class="inline"
                                                  onsubmit="return confirm('Permanently delete this project?')">
                                                @csrf
                                                <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete permanently">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        @endif

        <div class="pb-8 text-center text-xs text-gray-400">
            Portfolio Admin &copy; {{ date('Y') }} · Published projects appear on your public portfolio.
        </div>
    </div>

{{-- ── Add Project Modal ── --}}
<dialog id="projectAddDialog" class="rounded-2xl p-0 w-full max-w-2xl">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-md flex items-center justify-center" style="background:#C5A059;">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <h4 class="text-base font-semibold text-gray-900">New Project</h4>
        </div>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" action="{{ route('admin.projects.store') }}" class="p-5 space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input name="title" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" required placeholder="e.g. Portfolio Website">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Subtitle</label>
                <input name="subtitle" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="Short description">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Client Name</label>
                <input name="client_name" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="e.g. Acme Corp">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status</label>
                <select name="status" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Summary</label>
                <textarea name="summary" rows="3" class="w-full rounded-lg border text-sm px-3 py-2.5 resize-none" style="border-color:#e8e6e1;" placeholder="Brief description of the project..."></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Thumbnail URL</label>
                <input name="thumbnail_url" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" placeholder="https://...">
            </div>
        </div>
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
            <input name="featured" type="checkbox" value="1" class="w-4 h-4 rounded" style="accent-color:#C5A059;">
            <span>Mark as <strong>Featured</strong> project</span>
        </label>
        <div class="flex justify-end gap-2 pt-1">
            <button type="button" data-close-dialog class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50" style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white" style="background:#1a1a1a;">Create Project</button>
        </div>
    </form>
</dialog>

{{-- ── Edit Project Modal ── --}}
<dialog id="projectEditDialog" class="rounded-2xl p-0 w-full max-w-2xl">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <h4 class="text-base font-semibold text-gray-900">Edit Project</h4>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" id="projectEditForm" class="p-5 space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input name="title" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Subtitle</label>
                <input name="subtitle" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Client Name</label>
                <input name="client_name" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status</label>
                <select name="status" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Summary</label>
                <textarea name="summary" rows="3" class="w-full rounded-lg border text-sm px-3 py-2.5 resize-none" style="border-color:#e8e6e1;"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Thumbnail URL</label>
                <input name="thumbnail_url" class="w-full rounded-lg border text-sm px-3 py-2.5" style="border-color:#e8e6e1;">
            </div>
        </div>
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
            <input name="featured" type="checkbox" value="1" class="w-4 h-4 rounded" style="accent-color:#C5A059;">
            <span>Mark as <strong>Featured</strong> project</span>
        </label>
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
        const dlg = document.getElementById(openBtn.dataset.openDialog);
        if (!dlg) return;
        if (openBtn.dataset.openDialog === 'projectEditDialog') {
            const form = document.getElementById('projectEditForm');
            form.action = `/admin/projects/${openBtn.dataset.id}`;
            form.querySelector('[name="title"]').value         = openBtn.dataset.title     ?? '';
            form.querySelector('[name="subtitle"]').value      = openBtn.dataset.subtitle  ?? '';
            form.querySelector('[name="client_name"]').value   = openBtn.dataset.client    ?? '';
            form.querySelector('[name="status"]').value        = openBtn.dataset.status    ?? 'draft';
            form.querySelector('[name="summary"]').value       = openBtn.dataset.summary   ?? '';
            form.querySelector('[name="thumbnail_url"]').value = openBtn.dataset.thumbnail ?? '';
            form.querySelector('[name="featured"]').checked    = (openBtn.dataset.featured ?? '0') === '1';
        }
        dlg.showModal?.();
    }
    const closeBtn = e.target.closest('[data-close-dialog]');
    if (closeBtn) closeBtn.closest('dialog')?.close();
});
</script>

@include('partials.admin-layout-end')
