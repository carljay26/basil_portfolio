<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackingController extends Controller
{
    public function click(Request $request): Response
    {
        $request->validate([
            'key' => ['required', 'string', 'max:100'],
        ]);

        $today = now()->toDateString();
        $key = (string) $request->input('key');

        DB::table('site_views')->updateOrInsert(
            ['view_date' => $today],
            [
                'page_views' => 0,
                'clicks' => 0,
                'resume_downloads' => 0,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $column = $key === 'hero_resume' ? 'resume_downloads' : 'clicks';
        DB::table('site_views')->where('view_date', $today)->increment($column, 1, ['updated_at' => now()]);

        return response()->noContent();
    }
}

