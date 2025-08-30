<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerPath extends Model
{
    use HasFactory;
    protected $table = 'career_paths';
    protected $fillable = [
        // section_id removed - now handled via pivot table
    ];

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'career_path_section')
                    ->withPivot('order')
                    ->orderBy('career_path_section.order');
    }

    public function careers()
    {
        return $this->belongsToMany(Career::class, 'career_career_path');
    }
}
