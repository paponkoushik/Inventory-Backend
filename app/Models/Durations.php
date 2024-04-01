<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Durations extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'time'];
    protected $casts = ['title' => 'string', 'time' => 'string'];
}
