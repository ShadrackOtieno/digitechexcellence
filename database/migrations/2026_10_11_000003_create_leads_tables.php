<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $t) {
            $t->id();
            $t->string('reference')->unique();
            $t->string('name');
            $t->string('email');
            $t->string('phone')->nullable();
            $t->string('company')->nullable();
            $t->string('project_type');
            $t->string('budget')->nullable();
            $t->string('timeline')->nullable();
            $t->text('message');
            $t->string('status')->default('new');
            $t->text('admin_notes')->nullable();
            $t->timestamps();
            $t->index('status');
        });

        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('subject');
            $t->text('message');
            $t->boolean('is_read')->default(false);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('inquiries');
    }
};
