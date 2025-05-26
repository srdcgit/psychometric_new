<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
   protected $fillable = ['domain_id','section_id', 'question','uploaded_by', 'is_reverse'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
