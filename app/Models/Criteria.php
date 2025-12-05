<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    /** @use HasFactory<\Database\Factories\CriteriaFactory> */
    use HasFactory;
    
    protected $fillable = [
        'Code',
        'Name',
        'Type',
        'Weight',
    ];


    public function subCriteria()
    {
        return $this->hasMany(sub_criterion::class);
    }

    public function scores()
    {
        return $this->hasMany(alternatives_score::class);
    }

    public function pairWiseRows()
    {
        return $this->hasMany(criteria_pairwise::class,'criteria_row_id');
    }

    public function pairWiseCols()
    {
        return $this->hasMany(criteria_pairwise::class,'criteria_col_id');
    }
}
