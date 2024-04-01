<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Questions extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'question_type_id',
        'duration_id',
        'answer_explanation'
    ];

    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id', 'id');
    }

    public function duration(): BelongsTo
    {
        return $this->belongsTo(Durations::class, 'duration_id', 'id');
    }
}
