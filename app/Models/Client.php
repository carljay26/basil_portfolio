<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = ['profile_id', 'name', 'logo_url', 'website_url', 'position'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
