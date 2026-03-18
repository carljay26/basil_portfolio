<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContentController extends Controller
{
    private function getOrCreateProfile(): object
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        if ($profile) {
            return $profile;
        }

        $id = DB::table('profiles')->insertGetId([
            'name'       => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('profiles')->where('id', $id)->first();
    }

    public function index(Request $request): View
    {
        $edit = $request->boolean('edit');

        $profile = $this->getOrCreateProfile();
        $skills = DB::table('skills')->where('profile_id', $profile->id)->orderBy('position')->get();
        $tools = DB::table('tools')->where('profile_id', $profile->id)->orderBy('position')->get();
        $experiences = DB::table('experiences')->where('profile_id', $profile->id)->orderBy('position')->get();
        $clients = DB::table('clients')->where('profile_id', $profile->id)->orderBy('position')->get();
        $satisfactions = DB::table('satisfactions')->where('profile_id', $profile->id)->orderBy('position')->get();

        return view('admin-content', compact(
            'edit',
            'profile',
            'skills',
            'tools',
            'experiences',
            'clients',
            'satisfactions',
        ));
    }

    public function saveProfile(Request $request): RedirectResponse
    {
        $profile = $this->getOrCreateProfile();

        $data = $request->validate([
            'name'               => ['nullable', 'string', 'max:255'],
            'title'              => ['nullable', 'string', 'max:255'],
            'tagline'            => ['nullable', 'string', 'max:500'],
            'bio'                => ['nullable', 'string', 'max:5000'],
            'availability'       => ['nullable', 'string', 'max:255'],
            'profile_image_url'  => ['nullable', 'string', 'max:1000'],
            'resume_url'         => ['nullable', 'string', 'max:1000'],
            'email'              => ['nullable', 'string', 'max:255'],
            'phone'              => ['nullable', 'string', 'max:50'],
            'location'           => ['nullable', 'string', 'max:255'],
            'discord_url'        => ['nullable', 'string', 'max:1000'],
            'gmail_url'          => ['nullable', 'string', 'max:1000'],
            'facebook_url'       => ['nullable', 'string', 'max:1000'],
            'languages'          => ['nullable', 'string', 'max:255'],
            'current_engagement' => ['nullable', 'string', 'max:255'],
            'quote'              => ['nullable', 'string', 'max:1000'],
            'experience_years'   => ['nullable', 'integer', 'min:0', 'max:100'],
            'projects_count'     => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'clients_count'      => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'satisfaction_score' => ['nullable', 'string', 'max:50'],
            'profile_image_file' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('profile_image_file')) {
            $path = $request->file('profile_image_file')->store('avatars', 'public');
            $data['profile_image_url'] = Storage::url($path);
        }

        unset($data['profile_image_file']);

        DB::table('profiles')->where('id', $profile->id)->update(array_merge($data, [
            'updated_at' => now(),
        ]));

        return redirect()->route('admin.content')->with('saved', true);
    }

    public function addSkill(Request $request): RedirectResponse
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        if (!$profile) {
            return redirect()->route('admin.content');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
        ]);

        $maxPos = (int) DB::table('skills')->where('profile_id', $profile->id)->max('position');

        DB::table('skills')->insert([
            'profile_id' => $profile->id,
            'name' => $data['name'],
            'category' => $data['category'],
            'position' => $maxPos + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function deleteSkill(int $id): RedirectResponse
    {
        DB::table('skills')->where('id', $id)->delete();
        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function addTool(Request $request): RedirectResponse
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        if (!$profile) {
            return redirect()->route('admin.content');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
        ]);

        $maxPos = (int) DB::table('tools')->where('profile_id', $profile->id)->max('position');

        DB::table('tools')->insert([
            'profile_id' => $profile->id,
            'name' => $data['name'],
            'category' => $data['category'],
            'position' => $maxPos + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function deleteTool(int $id): RedirectResponse
    {
        DB::table('tools')->where('id', $id)->delete();
        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function addExperience(Request $request): RedirectResponse
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        if (!$profile) {
            return redirect()->route('admin.content');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'start_date' => ['nullable', 'string', 'max:50'],
            'end_date' => ['nullable', 'string', 'max:50'],
            'is_current' => ['nullable'],
        ]);

        $maxPos = (int) DB::table('experiences')->where('profile_id', $profile->id)->max('position');

        DB::table('experiences')->insert([
            'profile_id' => $profile->id,
            'title' => $data['title'],
            'company' => $data['company'] ?? null,
            'role' => $data['role'] ?? null,
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'is_current' => (bool) ($request->boolean('is_current')),
            'position' => $maxPos + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function updateExperience(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'start_date' => ['nullable', 'string', 'max:50'],
            'end_date' => ['nullable', 'string', 'max:50'],
            'is_current' => ['nullable'],
        ]);

        DB::table('experiences')->where('id', $id)->update([
            'title' => $data['title'],
            'company' => $data['company'] ?? null,
            'role' => $data['role'] ?? null,
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'is_current' => (bool) $request->boolean('is_current'),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function deleteExperience(int $id): RedirectResponse
    {
        DB::table('experiences')->where('id', $id)->delete();
        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function addClient(Request $request): RedirectResponse
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        if (!$profile) {
            return redirect()->route('admin.content');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo_url' => ['nullable', 'string', 'max:1000'],
            'website_url' => ['nullable', 'string', 'max:1000'],
        ]);

        $maxPos = (int) DB::table('clients')->where('profile_id', $profile->id)->max('position');

        DB::table('clients')->insert([
            'profile_id' => $profile->id,
            'name' => $data['name'],
            'logo_url' => $data['logo_url'] ?? null,
            'website_url' => $data['website_url'] ?? null,
            'position' => $maxPos + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function updateClient(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo_url' => ['nullable', 'string', 'max:1000'],
            'website_url' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::table('clients')->where('id', $id)->update([
            'name' => $data['name'],
            'logo_url' => $data['logo_url'] ?? null,
            'website_url' => $data['website_url'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function deleteClient(int $id): RedirectResponse
    {
        DB::table('clients')->where('id', $id)->delete();
        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function addSatisfaction(Request $request): RedirectResponse
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        if (!$profile) {
            return redirect()->route('admin.content');
        }

        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'author_role' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $maxPos = (int) DB::table('satisfactions')->where('profile_id', $profile->id)->max('position');

        DB::table('satisfactions')->insert([
            'profile_id' => $profile->id,
            'author_name' => $data['author_name'],
            'author_role' => $data['author_role'] ?? null,
            'content' => $data['content'],
            'rating' => $data['rating'] ?? null,
            'position' => $maxPos + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function updateSatisfaction(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'author_role' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        DB::table('satisfactions')->where('id', $id)->update([
            'author_name' => $data['author_name'],
            'author_role' => $data['author_role'] ?? null,
            'content' => $data['content'],
            'rating' => $data['rating'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.content', ['edit' => 1]);
    }

    public function deleteSatisfaction(int $id): RedirectResponse
    {
        DB::table('satisfactions')->where('id', $id)->delete();
        return redirect()->route('admin.content', ['edit' => 1]);
    }
}

