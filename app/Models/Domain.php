<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'instruction',
        'scoring_type',
        'domain_weightage',
        'uploaded_by'
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
