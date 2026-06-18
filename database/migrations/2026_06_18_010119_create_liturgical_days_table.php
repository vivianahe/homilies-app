<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('liturgical_days', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique()->nullable();

            $table->foreignId('liturgical_time_id')
                ->constrained('liturgical_times');

            $table->foreignId('gospel_id')
                ->nullable()
                ->constrained('gospels');

            $table->char('cycle', 1);

            $table->integer('week_number')->nullable();

            $table->string('day_name', 100)->nullable();

            $table->string('celebration_type', 100)->nullable();

            $table->text('description')->nullable();

            $table->timestamps();

            $table->index(
                ['liturgical_time_id', 'cycle', 'week_number'],
                'liturgical_days_search_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('liturgical_days');
    }
};