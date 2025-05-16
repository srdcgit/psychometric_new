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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->after('email');
            $table->string('class')->after('age');
            $table->string('school')->after('class');
            $table->string('location')->after('school');
            $table->string('subjects_stream')->after('location');
            $table->string('career_aspiration')->nullable()->after('subjects_stream');
            $table->string('parental_occupation')->nullable()->after('career_aspiration');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'class',
                'school',
                'location',
                'subjects_stream',
                'career_aspiration',
                'parental_occupation',
            ]);
        });
    }
};
