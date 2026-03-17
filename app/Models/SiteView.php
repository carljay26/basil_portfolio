<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteView extends Model
{
    protected $fillable = ['view_date', 'page_views', 'clicks', 'resume_downloads'];

    protected $casts = [
        'view_date' => 'date',
    ];

    public static function recordPageView(): void
    {
        $record = static::firstOrCreate(
            ['view_date' => now()->toDateString()],
            ['page_views' => 0, 'clicks' => 0, 'resume_downloads' => 0]
        );
        $record->increment('page_views');
    }

    public static function recordClick(): void
    {
        $record = static::firstOrCreate(
            ['view_date' => now()->toDateString()],
            ['page_views' => 0, 'clicks' => 0, 'resume_downloads' => 0]
        );
        $record->increment('clicks');
    }

    public static function recordResumeDownload(): void
    {
        $record = static::firstOrCreate(
            ['view_date' => now()->toDateString()],
            ['page_views' => 0, 'clicks' => 0, 'resume_downloads' => 0]
        );
        $record->increment('resume_downloads');
    }

    public static function getStatsForPeriod(int $days): array
    {
        $start = now()->subDays($days)->startOfDay();
        $records = static::where('view_date', '>=', $start)->get();

        return [
            'page_views' => $records->sum('page_views'),
            'clicks' => $records->sum('clicks'),
            'resume_downloads' => $records->sum('resume_downloads'),
            'days' => $days,
        ];
    }
}
