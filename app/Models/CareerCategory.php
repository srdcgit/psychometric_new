<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'career_categories';
    protected $fillable = ['name', 'hook', 'what_is_it', 'example_roles', 'subjects', 'core_apptitudes_to_highlight', 'value_and_personality_edge', 'why_it_could_fit_you', 'early_actions', 'india_study_pathways', 'future_trends']; // Add actual fields only, not _token

}