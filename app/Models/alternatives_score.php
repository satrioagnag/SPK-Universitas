<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alternatives_score extends Model
{
    /** @use HasFactory<\Database\Factories\AlternativesScoreFactory> */
    use HasFactory;

    protected $table = 'alternatives_scores';

    protected $fillable = [
        'alternative_id',
        'criterion_id',
        'sub_criterion_id',
        'Score',
    ];

    protected $casts = [
        'Score' => 'float',
    ];

    public function alternative()
    {
        return $this->belongsTo(Alternatif::class);
    }

    public function criterion()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function subCriterion()
    {
        return $this->belongsTo(sub_criteria::class);
    }
}
