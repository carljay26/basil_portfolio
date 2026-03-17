<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tool extends Model
{
    protected $fillable = ['profile_id', 'name', 'category', 'position'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
