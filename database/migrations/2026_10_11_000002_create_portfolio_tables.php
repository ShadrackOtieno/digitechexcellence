<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
            $t->timestamps();
        });

        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('technologies', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('group')->default('other');
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });

        Schema::create('projects', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('client_name');
            $t->string('industry')->nullable();
            $t->unsignedSmallInteger('year')->nullable();
            $t->string('role')->nullable();
            $t->string('duration')->nullable();
            $t->string('status')->default('live');
            $t->string('short_description', 500);
            $t->text('challenge')->nullable();
            $t->text('solution')->nullable();
            $t->text('results')->nullable();
            $t->string('live_url')->nullable();
            $t->string('repo_url')->nullable();
            $t->string('cover_image')->nullable();
            $t->boolean('is_featured')->default(false);
            $t->boolean('is_active')->default(true);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
            $t->index(['is_active', 'is_featured']);
        });

        Schema::create('project_images', function (Blueprint $t) {
            $t->id();
            $t->foreignId('project_id')->constrained()->cascadeOnDelete();
            $t->string('path');
            $t->string('caption')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });

        Schema::create('project_technology', function (Blueprint $t) {
            $t->id();
            $t->foreignId('project_id')->constrained()->cascadeOnDelete();
            $t->foreignId('technology_id')->constrained()->cascadeOnDelete();
            $t->unique(['project_id', 'technology_id']);
        });

        Schema::create('services', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('icon')->nullable();
            $t->string('summary', 500);
            $t->text('body')->nullable();
            $t->text('features')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('team_members', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('title');
            $t->text('bio')->nullable();
            $t->string('photo')->nullable();
            $t->string('github')->nullable();
            $t->string('linkedin')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $t) {
            $t->id();
            $t->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $t->string('author_name');
            $t->string('author_role')->nullable();
            $t->string('company')->nullable();
            $t->text('quote');
            $t->unsignedTinyInteger('rating')->default(5);
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['testimonials', 'team_members', 'services', 'project_technology', 'project_images', 'projects', 'technologies', 'categories', 'settings'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
