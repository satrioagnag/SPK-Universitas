<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class topsis_result extends Model
{
    /** @use HasFactory<\Database\Factories\TopsisResultFactory> */
    use HasFactory;

    protected $fillable = [
        'calculation__run_id',
        'alternative_id',
        'score',
        'rank',
    ];

    protected $casts = [
        'score' => 'decimal:6',
        'rank' => 'integer',
    ];

    public function Run()
    {
        return $this->belongsTo(calculation_Run::class, 'calculation__run_id');
    }

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}
