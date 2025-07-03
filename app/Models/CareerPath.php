<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerPath extends Model
{
    use HasFactory;
    protected $table = 'career_paths';
    protected $fillable = [
        'section_id',
        'name',

    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function careers()
    {
        return $this->belongsToMany(Career::class, 'career_career_path');
    }
}
