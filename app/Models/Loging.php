<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loging extends Model
{
  protected $fillable = [
    'user_name',
    'action',
    'ip',
    'browser',
  ];
    use HasFactory;
}
