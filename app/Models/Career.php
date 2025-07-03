<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Career extends Model
{
    use HasFactory;

    protected $table = 'careers';
    protected $fillable = [ 'career_category_id', 'name'];

    public function careerCategory()
    {
        return $this->belongsTo(CareerCategory::class, 'career_category_id');
    }

    public function careerPaths()
    {
        return $this->belongsToMany(CareerPath::class, 'career_career_path');
    }
}
