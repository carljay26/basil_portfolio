<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProjectsController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->input('tab', 'active');
        $activeProjects = DB::table('projects')
            ->whereIn('status', ['draft', 'published'])
            ->orderByDesc('updated_at')
            ->get();
        $archivedProjects = DB::table('projects')
            ->where('status', 'archived')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin-projects', compact('activeProjects', 'archivedProjects', 'tab'));
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = DB::table('profiles')->orderBy('id')->first();
        $data = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'subtitle'      => ['nullable', 'string', 'max:255'],
            'client_name'   => ['nullable', 'string', 'max:255'],
            'status'        => ['nullable', 'string', 'in:draft,published'],
            'summary'       => ['nullable', 'string', 'max:5000'],
            'thumbnail_url' => ['nullable', 'string', 'max:500'],
            'featured'      => ['nullable'],
        ]);

        DB::table('projects')->insert([
            'profile_id'    => $profile?->id,
            'title'         => $data['title'],
            'subtitle'      => $data['subtitle'] ?? null,
            'client_name'   => $data['client_name'] ?? null,
            'status'        => $data['status'] ?? 'draft',
            'summary'       => $data['summary'] ?? null,
            'thumbnail_url' => $data['thumbnail_url'] ?? null,
            'featured'      => !empty($data['featured']) ? 1 : 0,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->route('admin.projects')->with('project_saved', true);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'subtitle'      => ['nullable', 'string', 'max:255'],
            'client_name'   => ['nullable', 'string', 'max:255'],
            'status'        => ['nullable', 'string', 'in:draft,published'],
            'summary'       => ['nullable', 'string', 'max:5000'],
            'thumbnail_url' => ['nullable', 'string', 'max:500'],
            'featured'      => ['nullable'],
        ]);

        DB::table('projects')->where('id', $id)->update([
            'title'         => $data['title'],
            'subtitle'      => $data['subtitle'] ?? null,
            'client_name'   => $data['client_name'] ?? null,
            'status'        => $data['status'] ?? 'draft',
            'summary'       => $data['summary'] ?? null,
            'thumbnail_url' => $data['thumbnail_url'] ?? null,
            'featured'      => !empty($data['featured']) ? 1 : 0,
            'updated_at'    => now(),
        ]);

        return redirect()->route('admin.projects')->with('project_saved', true);
    }

    public function archive(int $id): RedirectResponse
    {
        DB::table('projects')->where('id', $id)->update(['status' => 'archived', 'updated_at' => now()]);
        return redirect()->route('admin.projects')->with('project_saved', true);
    }

    public function delete(int $id): RedirectResponse
    {
        DB::table('projects')->where('id', $id)->delete();
        return redirect()->route('admin.projects', ['tab' => 'archived'])->with('project_saved', true);
    }

    public function restore(int $id): RedirectResponse
    {
        DB::table('projects')->where('id', $id)->update(['status' => 'draft', 'updated_at' => now()]);
        return redirect()->route('admin.projects', ['tab' => 'archived'])->with('project_saved', true);
    }

    public function clearArchived(): RedirectResponse
    {
        DB::table('projects')->where('status', 'archived')->delete();
        return redirect()->route('admin.projects', ['tab' => 'archived'])->with('archived_cleared', true);
    }
}

