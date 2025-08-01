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
            $table->string('low')->nullable()->after('idealenvironments');
            $table->string('mid')->nullable()->after('low');
            $table->string('high')->nullable()->after('mid');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('low');
            $table->dropColumn('mid');
            $table->dropColumn('high');
        });
    }
};
