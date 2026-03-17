<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $fillable = [
        'profile_id', 'school', 'degree', 'field_of_study', 'level',
        'start_year', 'end_year', 'is_current', 'position',
    ];

    protected $casts = [];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
