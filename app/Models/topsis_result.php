<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class topsis_result extends Model
{
    use HasFactory;

    protected $fillable = [
        'calculation__run_id',
        'alternative_id',
        'score',
        'rank',
        'd_plus',
        'd_minus',
    ];

    protected $casts = [
        'score' => 'decimal:6',
        'rank' => 'integer',
        'd_plus' => 'decimal:6',
        'd_minus' => 'decimal:6',
    ];

    public function run()
    {
        return $this->belongsTo(calculation_Run::class, 'calculation__run_id');
    }

    public function alternative()
    {
        return $this->belongsTo(Alternatif::class, 'alternative_id');
    }
}