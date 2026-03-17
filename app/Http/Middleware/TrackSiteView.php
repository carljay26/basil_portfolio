<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteView
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only count successful HTML GET requests.
        if (!$request->isMethod('GET')) {
            return $response;
        }

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            return $response;
        }

        $contentType = (string) $response->headers->get('Content-Type');
        if ($contentType !== '' && !str_contains($contentType, 'text/html')) {
            return $response;
        }

        $today = now()->toDateString();

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

        DB::table('site_views')->where('view_date', $today)->increment('page_views', 1, [
            'updated_at' => now(),
        ]);

        return $response;
    }
}

