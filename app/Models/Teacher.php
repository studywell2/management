<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'subject',
        'phone',
    ];

    // Relationship: Teacher has many attendance records
    public function attendances()
    {
        return $this->hasMany(TeacherAttendance::class);
    }
}
