@include('partials.admin-layout', ['title' => 'Messages', 'active' => 'messages'])

    {{-- Page Header --}}
    <header class="bg-white px-8 py-5 flex justify-between items-center sticky top-0 z-10"
            style="border-bottom:1px solid #e8e6e1;">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Messages</h2>
            <p class="text-sm text-gray-400 mt-0.5">Inquiries received from the contact form.</p>
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

    <div class="p-8 max-w-5xl mx-auto space-y-5">

        {{-- Flash messages --}}
        @if (session('reply_sent'))
            <div class="flex items-center gap-3 rounded-xl px-5 py-3.5 text-sm font-medium"
                 style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Reply saved successfully.
            </div>
        @endif
        @if (session('message_deleted'))
            <div class="flex items-center gap-3 rounded-xl px-5 py-3.5 text-sm font-medium"
                 style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Message deleted.
            </div>
        @endif

        {{-- Empty state --}}
        @if ($messages->count() === 0)
            <div class="bg-white rounded-2xl py-20 text-center" style="border:1px solid #e8e6e1;">
                <div class="w-14 h-14 rounded-2xl mx-auto mb-5 flex items-center justify-center"
                     style="background:#f5f4f0;">
                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-base font-semibold text-gray-500 mb-1">No messages yet</p>
                <p class="text-sm text-gray-400">When visitors send you a message, it will appear here.</p>
            </div>
        @else

            {{-- Stats bar --}}
            @php
                $total   = $messages->count();
                $unread  = $messages->where('is_read', 0)->count();
                $replied = $messages->filter(fn($m) => $m->reply && trim($m->reply) !== '')->count();
            @endphp
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-xl px-5 py-4" style="border:1px solid #e8e6e1;">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $total }}</p>
                </div>
                <div class="bg-white rounded-xl px-5 py-4" style="border:1px solid #e8e6e1;">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1">Unread</p>
                    <p class="text-2xl font-bold" style="color:#1a1a1a;">{{ $unread }}</p>
                </div>
                <div class="bg-white rounded-xl px-5 py-4" style="border:1px solid #e8e6e1;">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1">Replied</p>
                    <p class="text-2xl font-bold" style="color:#C5A059;">{{ $replied }}</p>
                </div>
            </div>

            {{-- Message list --}}
            <div class="space-y-3">
                @foreach ($messages as $msg)
                    @php $replied = $msg->reply && trim($msg->reply) !== ''; @endphp
                    <div class="bg-white rounded-2xl overflow-hidden transition-all"
                         style="border:{{ !$msg->is_read ? '1.5px solid #1a1a1a' : '1px solid #e8e6e1' }};
                                box-shadow:{{ !$msg->is_read ? '0 2px 12px rgba(0,0,0,.08)' : '0 1px 3px rgba(0,0,0,.04)' }};">
                        <div class="px-6 py-5 flex items-start gap-4">
                            {{-- Avatar --}}
                            <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-bold shrink-0"
                                 style="{{ !$msg->is_read ? 'background:#1a1a1a; color:#C5A059;' : 'background:#f5f4f0; color:#9ca3af;' }}">
                                {{ strtoupper(substr($msg->name ?: '?', 0, 1)) }}
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <span class="text-sm font-semibold text-gray-900">{{ $msg->name }}</span>
                                    @if (!$msg->is_read)
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full text-white"
                                              style="background:#1a1a1a;">NEW</span>
                                    @endif
                                    @if ($replied)
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                              style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;">REPLIED</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 mb-2">
                                    {{ $msg->email }}
                                    @if ($msg->phone)
                                        <span class="mx-1.5">·</span>{{ $msg->phone }}
                                    @endif
                                    <span class="mx-1.5">·</span>
                                    {{ \Carbon\Carbon::parse($msg->created_at)->diffForHumans() }}
                                </p>
                                @if (!empty($msg->subject))
                                    <p class="text-xs font-semibold text-gray-600 mb-2">
                                        Subject: {{ $msg->subject }}
                                    </p>
                                @endif
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $msg->message }}</p>

                                @if ($replied)
                                    <div class="mt-4 pl-4 py-3 pr-3 rounded-lg"
                                         style="border-left:3px solid #C5A059; background:#fffbf0;">
                                        <p class="text-[10px] font-bold uppercase tracking-wider mb-1.5"
                                           style="color:#C5A059;">Your Reply</p>
                                        <p class="text-sm text-gray-700 leading-relaxed">{{ $msg->reply }}</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button"
                                        data-open-dialog="replyDialog"
                                        data-id="{{ $msg->id }}"
                                        data-name="{{ e($msg->name) }}"
                                        data-existing="{{ e($msg->reply ?? '') }}"
                                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors hover:bg-amber-50"
                                        style="color:#C5A059; border:1px solid #fde68a;"
                                        title="Reply">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                    </svg>
                                    Reply
                                </button>
                                <form method="POST" action="{{ route('admin.messages.delete', $msg->id) }}" class="inline"
                                      onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    <button type="submit"
                                            class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                            title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="pb-8 text-center text-xs text-gray-400">
            Portfolio Admin &copy; {{ date('Y') }} · Messages are stored securely in your database.
        </div>
    </div>

{{-- ── Reply Modal ── --}}
<dialog id="replyDialog" class="rounded-2xl p-0 w-full max-w-lg">
    <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #e8e6e1;">
        <div>
            <h4 class="text-base font-semibold text-gray-900">
                Reply to <span id="replyRecipientName" class="font-normal text-gray-500"></span>
            </h4>
            <p class="text-xs text-gray-400 mt-0.5">Your reply will be saved and shown in this panel.</p>
        </div>
        <button type="button" data-close-dialog class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <form method="POST" id="replyForm" class="p-5 space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                Reply Message <span class="text-red-500">*</span>
            </label>
            <textarea name="reply" id="replyText" rows="6" required
                      class="w-full rounded-lg border text-sm px-3 py-2.5 resize-none focus:outline-none"
                      style="border-color:#e8e6e1;"
                      placeholder="Write your reply here..."></textarea>
        </div>
        <div class="flex justify-end gap-2">
            <button type="button" data-close-dialog
                    class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50"
                    style="border:1px solid #e8e6e1;">Cancel</button>
            <button type="submit"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium text-white"
                    style="background:#1a1a1a;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Save Reply
            </button>
        </div>
    </form>
</dialog>

<script>
document.addEventListener('click', e => {
    const openBtn = e.target.closest('[data-open-dialog]');
    if (openBtn) {
        const dlg = document.getElementById(openBtn.dataset.openDialog);
        if (!dlg) return;
        if (openBtn.dataset.openDialog === 'replyDialog') {
            document.getElementById('replyRecipientName').textContent = openBtn.dataset.name ?? '';
            document.getElementById('replyText').value = openBtn.dataset.existing ?? '';
            document.getElementById('replyForm').action = `/admin/messages/${openBtn.dataset.id}/reply`;
        }
        dlg.showModal?.();
    }
    const closeBtn = e.target.closest('[data-close-dialog]');
    if (closeBtn) closeBtn.closest('dialog')?.close();
});
</script>

@include('partials.admin-layout-end')
