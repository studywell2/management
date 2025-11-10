<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'school_id',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    
    public function teacher()
{
    return $this->belongsTo(Teacher::class);
}

}
