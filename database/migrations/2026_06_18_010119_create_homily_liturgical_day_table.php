<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homily_liturgical_day', function (Blueprint $table) {
            $table->id();

            $table->foreignId('homily_id')
                ->constrained('homilies')
                ->cascadeOnDelete();

            $table->foreignId('liturgical_day_id')
                ->constrained('liturgical_days')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(
                ['homily_id', 'liturgical_day_id'],
                'homily_liturgical_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homily_liturgical_day');
    }
};