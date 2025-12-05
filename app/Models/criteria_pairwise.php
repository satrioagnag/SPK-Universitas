<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class criteria_pairwise extends Model
{
    /** @use HasFactory<\Database\Factories\CriteriaPairwiseFactory> */
    use HasFactory;

    protected $table = 'criteria_pairwises';

    protected $fillable = [
        'criteria_row_id',
        'criteria_col_id',
        'value',
    ];

    protected $casts = [
        'value' => 'float',
    ];

    public function rowCriterion()
    {
        return $this->belongsTo(Criteria::class, 'criterion_row_id');
    }

    public function colCriterion()
    {
        return $this->belongsTo(Criteria::class, 'criterion_col_id');
    }
}
