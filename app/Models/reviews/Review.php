<?php

namespace App\Models\reviews;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    public $increment = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'title',
        'description',
    ];

    /**
     * Get the user that owns the Review.
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,  'user_id');
    }
}
