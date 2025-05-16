<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
   protected $fillable = ['domain_id','section_id', 'question','uploaded_by'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
