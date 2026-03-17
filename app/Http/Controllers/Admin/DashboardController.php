<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $range = request('range', '7d');
        $days = $range === '30d' ? 30 : 7;

        $start = now()->subDays($days - 1)->toDateString();
        $trafficRows = DB::table('site_views')
            ->where('view_date', '>=', $start)
            ->orderBy('view_date')
            ->get()
            ->keyBy('view_date');

        $traffic = collect();
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $row = $trafficRows->get($date);
            $traffic->push((object) [
                'view_date' => $date,
                'page_views' => (int) ($row->page_views ?? 0),
                'clicks' => (int) ($row->clicks ?? 0),
                'resume_downloads' => (int) ($row->resume_downloads ?? 0),
            ]);
        }

        $trafficTotals = [
            'page_views' => (int) $traffic->sum('page_views'),
            'clicks' => (int) $traffic->sum('clicks'),
            'resume_downloads' => (int) $traffic->sum('resume_downloads'),
        ];

        $messagesTotal = (int) DB::table('contact_messages')->count();
        $messagesUnread = (int) DB::table('contact_messages')->where('is_read', 0)->count();
        $recentMessages = DB::table('contact_messages')->orderByDesc('created_at')->limit(5)->get();

        $activeProjects = DB::table('projects')
            ->whereIn('status', ['draft', 'published'])
            ->orderByDesc('updated_at')
            ->limit(8)
            ->get();

        $activeProjectsCount = (int) DB::table('projects')->whereIn('status', ['draft', 'published'])->count();

        return view('admin', [
            'range' => $range,
            'days' => $days,
            'traffic' => $traffic,
            'trafficTotals' => $trafficTotals,
            'messagesTotal' => $messagesTotal,
            'messagesUnread' => $messagesUnread,
            'recentMessages' => $recentMessages,
            'activeProjects' => $activeProjects,
            'activeProjectsCount' => $activeProjectsCount,
        ]);
    }
}

