<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerCareerPath extends Model
{
    use HasFactory;
    protected $table = 'career_career_path';
    protected $fillable = [
        'career_id',
        'career_path_id',

    ];

    
}
