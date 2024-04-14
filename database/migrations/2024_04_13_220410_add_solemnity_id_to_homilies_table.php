<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('homilies', function (Blueprint $table) {
            $table->unsignedBigInteger('solemnity_id')->nullable()->after('user_id');
            $table->foreign('solemnity_id')->references('id')->on('solemnity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homilies', function (Blueprint $table) {
            //
        });
    }
};
