<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\alternatives_score;

class Alternatif extends Model
{
    /** @use HasFactory<\Database\Factories\AlternatifFactory> */
    use HasFactory;

    protected $table = 'alternatifs';

    protected $fillable = [
        'Code',
        'Name',
        'Type',
        'Weight',
    ];

    public function scores()
    {
        return $this->hasMany(alternatives_score::class);
    }

    public function topsisResults()
    {
        return $this->hasMany(Topsis_Result::class);
    }
}
