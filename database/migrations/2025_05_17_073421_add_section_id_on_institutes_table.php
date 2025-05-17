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
        Schema::table('institutes', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id')->after('description')->nullable();

            $table->foreign('section_id')
                ->references('id')
                ->on('institutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institutes', function (Blueprint $table) {
             $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');
        });
    }
};
