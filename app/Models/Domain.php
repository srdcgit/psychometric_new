<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'scoring_type',
        'uploaded_by'
    ];

    public function sections()
{
    return $this->hasMany(Section::class);
}

}
