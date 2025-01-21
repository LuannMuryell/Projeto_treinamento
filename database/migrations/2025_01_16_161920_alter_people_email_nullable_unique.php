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
        Schema::table('people', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->string('phone')->nullable()->change();
            $table->string('email')->unique()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change();
            $table->string('email')->unique(false)->nullable(false)->change();
        });
    }
};
