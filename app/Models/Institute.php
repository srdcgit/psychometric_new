<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'mobile',
        'allowed_students',
        'contact_person',

    ];
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function registeredStudents()
    {
        return $this->hasMany(User::class, 'register_institute_id');
    }
}
