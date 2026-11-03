<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Named "job_listings" because Laravel already ships a "jobs" queue table.
return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('location');
            $table->string('type')->default('Full-time');
            $table->string('level')->default('Mid');
            $table->unsignedInteger('salary_min')->nullable();
            $table->unsignedInteger('salary_max')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status')->default('draft'); // draft | published | closed
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
