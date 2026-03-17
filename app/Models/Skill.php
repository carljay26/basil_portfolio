<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = ['profile_id', 'name', 'category', 'proficiency', 'position'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
