<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('readings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('liturgical_day_id')
                ->constrained('liturgical_days')
                ->cascadeOnDelete();

            $table->enum('type', [
                'first_reading',
                'psalm',
                'second_reading',
                'gospel'
            ]);

            $table->string('title')->nullable();

            $table->string('reference_text')->nullable();

            $table->longText('content')->nullable();

            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};