<?php

namespace App\Models\points;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Points extends Model
{
    use HasFactory;

    protected $table = 'points';

    /**
     * Get all of the points_multipliers for the Point.
     */
    public function points_multipliers(): HasMany
    {
        return $this->hasMany(PointsMultiplier::class, 'points_id', 'id');
    }

    // ======================== RELATIONSHIPS ==============================
    /*
     * The groups that belong to the Point.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'points_multipliers', 'points_id', 'group_id')
            ->withPivot('id', 'multiplier', 'start_date', 'expiry_date')
            ->withTimestamps()
        ;
    }
}
