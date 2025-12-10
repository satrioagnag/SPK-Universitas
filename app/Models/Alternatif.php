<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatifs';

    protected $fillable = [
        'Code',
        'Name',
    ];

    public function scores()
    {
        return $this->hasMany(alternatives_score::class, 'alternative_id');
    }

    public function topsisResults()
    {
        return $this->hasMany(topsis_result::class, 'alternative_id');
    }
}