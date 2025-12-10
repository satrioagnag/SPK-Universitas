<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alternatives_score extends Model
{
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
        return $this->belongsTo(Alternatif::class, 'alternative_id');
    }

    public function criterion()
    {
        return $this->belongsTo(Criteria::class, 'criterion_id');
    }

    public function subCriterion()
    {
        return $this->belongsTo(sub_criterion::class, 'sub_criterion_id');
    }
}
