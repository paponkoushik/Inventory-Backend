<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_total_duration', 'duration'];

    protected $casts = ['title' => 'string', 'is_total_duration' => 'boolean', 'duration' => 'string'];

    public function duration(): BelongsTo
    {
        return $this->belongsTo(Durations::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Questions::class);
    }
}
