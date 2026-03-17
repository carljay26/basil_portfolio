<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Satisfaction extends Model
{
    protected $fillable = ['profile_id', 'author_name', 'author_role', 'content', 'rating', 'position'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
