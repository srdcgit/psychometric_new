<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'domain_id'];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
