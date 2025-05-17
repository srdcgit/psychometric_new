<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = [
        'name',
        'address',
        'mobile',
        'description',
        'section_id',
        'student_id'

    ];
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
