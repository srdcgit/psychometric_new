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
        Schema::table('career_categories', function (Blueprint $table) {
            $table->string('hook')->nullable()->after('name');
            $table->string('what_is_it')->nullable()->after('hook');
            $table->string('example_roles')->nullable()->after('what_is_it');
            $table->string('subjects')->nullable()->after('example_roles');
            $table->string('core_apptitudes_to_highlight')->nullable()->after('subjects');
            $table->string('value_and_personality_edge')->nullable()->after('core_apptitudes_to_highlight');
            $table->string('why_it_could_fit_you')->nullable()->after('value_and_personality_edge');
            $table->string('early_actions')->nullable()->after('why_it_could_fit_you');
            $table->string('india_study_pathways')->nullable()->after('early_actions');
            $table->string('future_trends')->nullable()->after('india_study_pathways');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_categories', function (Blueprint $table) {
            $table->dropColumn('hook');
            $table->dropColumn('what_is_it');
            $table->dropColumn('example_roles');
            $table->dropColumn('subjects');
            $table->dropColumn('core_apptitudes_to_highlight');
            $table->dropColumn('value_and_personality_edge');
            $table->dropColumn('why_it_could_fit_you');
            $table->dropColumn('early_actions');
            $table->dropColumn('india_study_pathways');
            $table->dropColumn('future_trends');
        });
    }
};
