<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessagesController extends Controller
{
    public function index(): View
    {
        $messages = DB::table('contact_messages')->orderByDesc('created_at')->get();

        DB::table('contact_messages')->where('is_read', 0)->update(['is_read' => 1]);

        return view('admin-messages', compact('messages'));
    }

    public function reply(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'reply' => ['required', 'string', 'max:5000'],
        ]);

        DB::table('contact_messages')->where('id', $id)->update([
            'reply' => $data['reply'],
            'reply_sent_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.messages')->with('reply_sent', true);
    }

    public function delete(int $id): RedirectResponse
    {
        DB::table('contact_messages')->where('id', $id)->delete();
        return redirect()->route('admin.messages')->with('message_deleted', true);
    }
}

