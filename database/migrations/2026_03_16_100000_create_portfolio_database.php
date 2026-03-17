<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * Single consolidated migration for the full portfolio database.
 * No generic `users` table — admin credentials live in `admin_accounts`.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ─── Admin Account ───────────────────────────────────────────────────
        if (! Schema::hasTable('admin_accounts')) {
            Schema::create('admin_accounts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // ─── Profile ──────────────────────────────────────────────────────────
        // One row = one portfolio owner.
        if (! Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->id();

                // Hero / Identity
                $table->string('name')->default('');                  // Full name
                $table->string('title')->nullable();                  // e.g. UI/UX Designer
                $table->string('tagline', 500)->nullable();           // Hero tagline
                $table->string('availability')->nullable();           // e.g. Open to Work
                $table->string('profile_image_url', 1000)->nullable();// Profile picture

                // About Me
                $table->text('bio')->nullable();                      // Biography / About Me

                // Contact (shown publicly)
                $table->string('email')->nullable();
                $table->string('phone', 50)->nullable();
                $table->string('location')->nullable();

                // Contact Links
                $table->string('gmail_url', 1000)->nullable();
                $table->string('facebook_url', 1000)->nullable();
                $table->string('discord_url', 1000)->nullable();

                // Extra
                $table->string('current_engagement')->nullable();     // Current Professional Engagement
                $table->string('languages')->nullable();              // e.g. English, Filipino
                $table->text('quote')->nullable();
                $table->string('resume_url', 1000)->nullable();

                // Stats (manually set numbers for hero section)
                $table->unsignedSmallInteger('experience_years')->nullable();
                $table->unsignedInteger('projects_count')->nullable();
                $table->unsignedInteger('clients_count')->nullable();
                $table->string('satisfaction_score', 50)->nullable(); // e.g. 4.9/5

                $table->timestamps();
            });
        }

        // ─── Experience ───────────────────────────────────────────────────────
        if (! Schema::hasTable('experiences')) {
            Schema::create('experiences', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
                $table->string('title');                              // Job title
                $table->string('company')->nullable();
                $table->string('role')->nullable();                   // e.g. Full-time / Freelance
                $table->text('description')->nullable();
                $table->string('start_date', 50)->nullable();
                $table->string('end_date', 50)->nullable();
                $table->boolean('is_current')->default(false);
                $table->unsignedInteger('position')->default(0);
                $table->timestamps();
            });
        }

        // ─── Projects ────────────────────────────────────────────────────────
        if (! Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->string('client_name')->nullable();
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
                $table->text('summary')->nullable();
                $table->string('thumbnail_url', 1000)->nullable();
                $table->boolean('featured')->default(false);
                $table->unsignedInteger('position')->default(0);
                $table->timestamps();
            });
        }

        // ─── Clients ─────────────────────────────────────────────────────────
        if (! Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('logo_url', 1000)->nullable();
                $table->string('website_url', 1000)->nullable();
                $table->unsignedInteger('position')->default(0);
                $table->timestamps();
            });
        }

        // ─── Skills / Expertise ───────────────────────────────────────────────
        if (! Schema::hasTable('skills')) {
            Schema::create('skills', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('category')->nullable();               // e.g. Design, Development
                $table->unsignedInteger('position')->default(0);
                $table->timestamps();
            });
        }

        // ─── Tools ────────────────────────────────────────────────────────────
        if (! Schema::hasTable('tools')) {
            Schema::create('tools', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('category')->nullable();
                $table->unsignedInteger('position')->default(0);
                $table->timestamps();
            });
        }

        // ─── Satisfaction / Reviews ───────────────────────────────────────────
        if (! Schema::hasTable('satisfactions')) {
            Schema::create('satisfactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
                $table->string('author_name');
                $table->string('author_role')->nullable();
                $table->text('content');
                $table->unsignedTinyInteger('rating')->nullable();    // 1–5
                $table->unsignedInteger('position')->default(0);
                $table->timestamps();
            });
        }

        // ─── Contact Messages ─────────────────────────────────────────────────
        // Visitor / user contact info (NOT admin — admin is in admin_accounts)
        if (! Schema::hasTable('contact_messages')) {
            Schema::create('contact_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profile_id')->nullable()->constrained()->nullOnDelete();

                // Visitor details
                $table->string('name');
                $table->string('email');
                $table->string('phone', 50)->nullable();
                $table->string('subject')->nullable();
                $table->text('message');

                // Admin reply
                $table->text('reply')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamp('replied_at')->nullable();

                $table->timestamps();
            });
        }

        // ─── Site Views (analytics) ───────────────────────────────────────────
        if (! Schema::hasTable('site_views')) {
            Schema::create('site_views', function (Blueprint $table) {
                $table->id();
                $table->date('view_date')->unique();
                $table->unsignedInteger('page_views')->default(0);
                $table->unsignedInteger('clicks')->default(0);
                $table->unsignedInteger('resume_downloads')->default(0);
                $table->timestamps();
            });
        }

        // ─── Seed default admin account ───────────────────────────────────────
        if (Schema::hasTable('admin_accounts') && ! DB::table('admin_accounts')->exists()) {
            DB::table('admin_accounts')->insert([
                'name'       => 'Admin',
                'email'      => 'basilfulgencio@gmail.com',
                'password'   => Hash::make('Admin@1234'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_views');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('satisfactions');
        Schema::dropIfExists('tools');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('admin_accounts');
    }
};
