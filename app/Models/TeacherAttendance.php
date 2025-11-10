<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'date',
        'sign_in',
        'sign_out',
    ];

    // Relationship: Attendance belongs to a teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Optional: cast date & time fields
    protected $casts = [
        'date' => 'date',
        'sign_in' => 'datetime:H:i',
        'sign_out' => 'datetime:H:i',
    ];
}
