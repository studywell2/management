<?php

namespace App\Models;

use App\Models\Result;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // ✅ Include school_class_id instead of class
    protected $fillable = ['name', 'student_id', 'school_id', 'school_class_id'];

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}
