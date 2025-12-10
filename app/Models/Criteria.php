<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'Code',
        'Name',
        'Type',
        'Weight',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'Weight' => 'float',
    ];

    // Default values
    protected $attributes = [
        'is_active' => true,
        'Weight' => 0,
    ];

    public function subCriteria()
    {
        return $this->hasMany(sub_criterion::class, 'criteria_id');
    }

    public function scores()
    {
        return $this->hasMany(alternatives_score::class, 'criterion_id');
    }

    public function pairWiseRows()
    {
        return $this->hasMany(criteria_pairwise::class, 'criteria_row_id');
    }

    public function pairWiseCols()
    {
        return $this->hasMany(criteria_pairwise::class, 'criteria_col_id');
    }
}
