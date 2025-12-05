<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TopsisResult;

class calculation_Run extends Model
{
    /** @use HasFactory<\Database\Factories\CalculationRunFactory> */
    use HasFactory;

    protected $fillable = [
        'method',
        'note',
        'run_at',
    ];

    protected $casts = [
        'run_at' => 'datetime',
    ];

    public function results()
    {
        return $this->hasMany(Topsis_Result::class);
    }
}
