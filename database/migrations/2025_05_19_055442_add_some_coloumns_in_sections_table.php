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
        Schema::table('sections', function (Blueprint $table) {
            $table->string('keytraits')->nullable()->after('description');
            $table->string('enjoys')->nullable()->after('keytraits');
            $table->string('idealenvironments')->nullable()->after('enjoys');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn(['keytraits', 'enjoys', 'idealenvironments']);
        });
    }
};
