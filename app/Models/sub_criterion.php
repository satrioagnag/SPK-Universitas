<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_criterion extends Model
{
    /** @use HasFactory<\Database\Factories\SubCriteriaFactory> */
    use HasFactory;

    protected $table = 'sub_criterias';

    protected $fillable = [
        'criteria_id',
        'label',
        'Score',
    ];

    protected $casts = [
        'Score' => 'float',
    ];

    public function criterion()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function scores()
    {
        return $this->hasMany(alternatives_score::class);
    }
}
