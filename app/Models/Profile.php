<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $fillable = [
        'name', 'title', 'tagline', 'availability',
        'profile_image_url', 'bio', 'email', 'phone', 'location',
        'gmail_url', 'facebook_url', 'discord_url', 'resume_url',
        'current_engagement', 'languages', 'quote',
        'experience_years', 'projects_count', 'clients_count', 'satisfaction_score',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->orderBy('position');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class)->orderBy('position');
    }

    public function tools(): HasMany
    {
        return $this->hasMany(Tool::class)->orderBy('position');
    }

    public function contactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class)->orderBy('position');
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class)->orderBy('position');
    }

    public function satisfactions(): HasMany
    {
        return $this->hasMany(Satisfaction::class)->orderBy('position');
    }

    public static function active(): ?self
    {
        return static::first();
    }
}
