<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
     use HasFactory;

    protected $fillable = [
        'domain_id',
        'section_id',
        'student_id',
        'question_id',
        'response_value',
    ];

    // Relationships (optional but useful)
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
        // If you use User instead: return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
