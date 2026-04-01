<?php

namespace App\Models\points;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PointsMultiplier extends Pivot
{
    use HasFactory;

    protected $table = 'points_multipliers';

    protected $primaryKey = 'id';
}
