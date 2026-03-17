<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private function getOrCreateProfile(): object
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        if ($profile) {
            return $profile;
        }

        $profileId = DB::table('profiles')->insertGetId([
            'name'       => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('profiles')->where('id', $profileId)->first();
    }

    public function index(): View
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        return view('admin-settings', compact('profile'));
    }

    public function save(Request $request): RedirectResponse
    {
        $profile = $this->getOrCreateProfile();

        $data = $request->validate([
            'name'               => ['nullable', 'string', 'max:255'],
            'title'              => ['nullable', 'string', 'max:255'],
            'availability'       => ['nullable', 'string', 'max:255'],
            'tagline'            => ['nullable', 'string', 'max:500'],
            'bio'                => ['nullable', 'string', 'max:5000'],
            'email'              => ['nullable', 'email', 'max:255'],
            'phone'              => ['nullable', 'string', 'max:50'],
            'location'           => ['nullable', 'string', 'max:255'],
            'discord_url'        => ['nullable', 'string', 'max:500'],
            'gmail_url'          => ['nullable', 'string', 'max:500'],
            'facebook_url'       => ['nullable', 'string', 'max:500'],
            'resume_url'         => ['nullable', 'string', 'max:500'],
            'profile_image_url'  => ['nullable', 'string', 'max:500'],
            'experience_years'   => ['nullable', 'integer', 'min:0', 'max:100'],
            'projects_count'     => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'clients_count'      => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'satisfaction_score' => ['nullable', 'string', 'max:50'],
            'languages'          => ['nullable', 'string', 'max:255'],
            'current_engagement' => ['nullable', 'string', 'max:255'],
            'quote'              => ['nullable', 'string', 'max:500'],
            'new_password'       => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::table('profiles')->where('id', $profile->id)->update([
            'name'               => $data['name'] ?? $profile->name,
            'title'              => $data['title'] ?? null,
            'availability'       => $data['availability'] ?? null,
            'tagline'            => $data['tagline'] ?? null,
            'bio'                => $data['bio'] ?? null,
            'email'              => $data['email'] ?? null,
            'phone'              => $data['phone'] ?? null,
            'location'           => $data['location'] ?? null,
            'discord_url'        => $data['discord_url'] ?? null,
            'gmail_url'          => $data['gmail_url'] ?? null,
            'facebook_url'       => $data['facebook_url'] ?? null,
            'resume_url'         => $data['resume_url'] ?? null,
            'profile_image_url'  => $data['profile_image_url'] ?? null,
            'experience_years'   => $data['experience_years'] ?? null,
            'projects_count'     => $data['projects_count'] ?? null,
            'clients_count'      => $data['clients_count'] ?? null,
            'satisfaction_score' => $data['satisfaction_score'] ?? null,
            'languages'          => $data['languages'] ?? null,
            'current_engagement' => $data['current_engagement'] ?? null,
            'quote'              => $data['quote'] ?? null,
            'updated_at'         => now(),
        ]);

        if (!empty($data['new_password'])) {
            $admin = DB::table('admin_accounts')->first();
            if ($admin) {
                DB::table('admin_accounts')->where('id', $admin->id)->update([
                    'password'   => Hash::make($data['new_password']),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.settings')->with('settings_saved', true);
    }
}

