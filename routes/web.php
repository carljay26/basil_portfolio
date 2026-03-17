<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(\App\Http\Middleware\TrackSiteView::class)
    ->get('/', [\App\Http\Controllers\Public\HomeController::class, 'index']);

Route::get('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
Route::post('/admin/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');

Route::get('/admin/content', [\App\Http\Controllers\Admin\ContentController::class, 'index'])
    ->middleware('auth')
    ->name('admin.content');

Route::post('/admin/content/profile', [\App\Http\Controllers\Admin\ContentController::class, 'saveProfile'])
    ->middleware('auth')
    ->name('admin.content.profile.save');

Route::post('/admin/content/skill', [\App\Http\Controllers\Admin\ContentController::class, 'addSkill'])
    ->middleware('auth')
    ->name('admin.content.skill.add');

Route::post('/admin/content/skill/{id}/delete', [\App\Http\Controllers\Admin\ContentController::class, 'deleteSkill'])
    ->middleware('auth')
    ->name('admin.content.skill.delete');

Route::post('/admin/content/tool', [\App\Http\Controllers\Admin\ContentController::class, 'addTool'])
    ->middleware('auth')
    ->name('admin.content.tool.add');

Route::post('/admin/content/tool/{id}/delete', [\App\Http\Controllers\Admin\ContentController::class, 'deleteTool'])
    ->middleware('auth')
    ->name('admin.content.tool.delete');

Route::post('/admin/content/experience', [\App\Http\Controllers\Admin\ContentController::class, 'addExperience'])
    ->middleware('auth')
    ->name('admin.content.experience.add');

Route::post('/admin/content/experience/{id}', [\App\Http\Controllers\Admin\ContentController::class, 'updateExperience'])
    ->middleware('auth')
    ->name('admin.content.experience.update');

Route::post('/admin/content/experience/{id}/delete', [\App\Http\Controllers\Admin\ContentController::class, 'deleteExperience'])
    ->middleware('auth')
    ->name('admin.content.experience.delete');

Route::post('/admin/content/client', [\App\Http\Controllers\Admin\ContentController::class, 'addClient'])
    ->middleware('auth')
    ->name('admin.content.client.add');

Route::post('/admin/content/client/{id}', [\App\Http\Controllers\Admin\ContentController::class, 'updateClient'])
    ->middleware('auth')
    ->name('admin.content.client.update');

Route::post('/admin/content/client/{id}/delete', [\App\Http\Controllers\Admin\ContentController::class, 'deleteClient'])
    ->middleware('auth')
    ->name('admin.content.client.delete');

Route::post('/admin/content/satisfaction', [\App\Http\Controllers\Admin\ContentController::class, 'addSatisfaction'])
    ->middleware('auth')
    ->name('admin.content.satisfaction.add');

Route::post('/admin/content/satisfaction/{id}', [\App\Http\Controllers\Admin\ContentController::class, 'updateSatisfaction'])
    ->middleware('auth')
    ->name('admin.content.satisfaction.update');

Route::post('/admin/content/satisfaction/{id}/delete', [\App\Http\Controllers\Admin\ContentController::class, 'deleteSatisfaction'])
    ->middleware('auth')
    ->name('admin.content.satisfaction.delete');

Route::post('/track/click', [\App\Http\Controllers\Public\TrackingController::class, 'click'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('track.click');

Route::post('/contact', [\App\Http\Controllers\Public\ContactController::class, 'submit'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('contact.submit');

// Optional: keep /admin working by redirecting to /admin/login
Route::redirect('/admin', '/admin/login');

// ─────────────────────────────────────────────────────────────
// Admin – Projects
// ─────────────────────────────────────────────────────────────
Route::get('/admin/projects', [\App\Http\Controllers\Admin\ProjectsController::class, 'index'])
    ->middleware('auth')
    ->name('admin.projects');

Route::post('/admin/projects', [\App\Http\Controllers\Admin\ProjectsController::class, 'store'])
    ->middleware('auth')
    ->name('admin.projects.store');

Route::post('/admin/projects/{id}', [\App\Http\Controllers\Admin\ProjectsController::class, 'update'])
    ->middleware('auth')
    ->name('admin.projects.update');

Route::post('/admin/projects/{id}/archive', [\App\Http\Controllers\Admin\ProjectsController::class, 'archive'])
    ->middleware('auth')
    ->name('admin.projects.archive');

Route::post('/admin/projects/{id}/delete', [\App\Http\Controllers\Admin\ProjectsController::class, 'delete'])
    ->middleware('auth')
    ->name('admin.projects.delete');

Route::post('/admin/projects/{id}/restore', [\App\Http\Controllers\Admin\ProjectsController::class, 'restore'])
    ->middleware('auth')
    ->name('admin.projects.restore');

Route::post('/admin/projects/clear-archived', [\App\Http\Controllers\Admin\ProjectsController::class, 'clearArchived'])
    ->middleware('auth')
    ->name('admin.projects.clear-archived');

// ─────────────────────────────────────────────────────────────
// Admin – Messages
// ─────────────────────────────────────────────────────────────
Route::get('/admin/messages', [\App\Http\Controllers\Admin\MessagesController::class, 'index'])
    ->middleware('auth')
    ->name('admin.messages');

Route::post('/admin/messages/{id}/reply', [\App\Http\Controllers\Admin\MessagesController::class, 'reply'])
    ->middleware('auth')
    ->name('admin.messages.reply');

Route::post('/admin/messages/{id}/delete', [\App\Http\Controllers\Admin\MessagesController::class, 'delete'])
    ->middleware('auth')
    ->name('admin.messages.delete');

// ─────────────────────────────────────────────────────────────
// Admin – Settings
// ─────────────────────────────────────────────────────────────
Route::get('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])
    ->middleware('auth')
    ->name('admin.settings');

Route::post('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'save'])
    ->middleware('auth')
    ->name('admin.settings.save');

// ─────────────────────────────────────────────────────────────
// Public viewer pages
// ─────────────────────────────────────────────────────────────
Route::middleware(\App\Http\Middleware\TrackSiteView::class)->group(function () {
    Route::get('/about', [\App\Http\Controllers\Public\PagesController::class, 'about'])->name('about');
    Route::get('/projects', [\App\Http\Controllers\Public\PagesController::class, 'projects'])->name('projects.public');
    Route::get('/skills', [\App\Http\Controllers\Public\PagesController::class, 'skills'])->name('skills.public');
    Route::get('/reviews', [\App\Http\Controllers\Public\PagesController::class, 'reviews'])->name('reviews.public');
    Route::get('/contact', [\App\Http\Controllers\Public\PagesController::class, 'contact'])->name('contact.page');
});
