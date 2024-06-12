<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assist extends Model
{
    protected $fillable = [
      'student_dni',
      'assist_date',
      'modified_at'
    ];
  function student_assist(): BelongsTo
  {
    return $this->belongsTo(Student::class, 'student_dni', 'dni_student');
  }
    use HasFactory;
}
