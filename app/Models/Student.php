<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;
  protected $fillable = [
    'dni_student',
    'name',
    'last_name',
    'birthday',
    'group_student',
    'year_id'
  ];
  function assists():HasMany
  {
    return $this->hasMany(Assist::class);
  }
  function year(): BelongsTo{
    return $this->belongsTo(Year::class);
  }
}
