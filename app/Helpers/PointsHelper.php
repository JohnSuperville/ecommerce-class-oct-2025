<?php

namespace App\Helpers;

use App\Models\points\Points;
use App\Models\points\PointsDiscount;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PointsHelper
{
    public int $total = 0;
    public int $discounted_price = 0;
    public int $base_points = 0;
    public int $multiplier = 1;
    public int $user_points = 0;
    public array $group_ids = [1];
    public string $group_title = '';

    public function __construct($cart_total, $user_points, $group_ids = [1])
    {
        $this->total = $cart_total;
        $this->user_points = $user_points;
        $this->group_ids = $group_ids;
        $this->setPoints();
        $this->getPointsGained();
    }

    public function setPoints()
    {
        $points_data = Points::with(['groups' => function (Builder $query) {
            $query->whereIn('group_id', $this->group_ids)
                ->where('start_date', '<=', Carbon::now())
                ->where('expiry_date', '>', Carbon::now())
                ->reorder('multiplier', 'desc');
        }])
            ->where('start_date', '<=', Carbon::now())
            ->where('expiry_date', '>', Carbon::now())
            ->orderby('points_per_dollar', 'desc')
            ->get();
        $this->base_points = $points_data[0]->points_per_dollar;
        $this->multiplier = $points_data[0]->groups[0]->pivot->multiplier ?? 1;
        $this->group_title = $points_data[0]->groups[0]->title ?? 'Tier 1';
    }

    public static function exchangePoints($points_exchanged)
    {
        try {
            $points_exchanged = (int) $points_exchanged;

            if ($points_exchanged > Auth::user()->total_points) {
                return 'You do not have enough points';
            }

            $reward = PointsDiscount::where('points_needed', $points_exchanged)->first();
            session(['points_discount_applied' => $reward->discount_percent]);
            session(['points_exchanged' => $reward->points_needed]);

            return 'Discount Applied';
        } catch (\Throwable $th) {
            // throw $th;

            self::clearPointsSession();

            session()->forget('points_discount_applied');
            session()->forget('points_exchanged');

            return 'Discount Removed';
        }
    }

    public static function clearPointsSession()
    {
        session()->forget('points_discount_applied');
        session()->forget('points_exchanged');
    }

    public function isDiscountApplied()
    {
        return session()->has('points_discount_applied');
    }

    public function getPoints()
    {
        return $this->base_points * $this->multiplier;
    }

    public function calculateDiscountedPrice()
    {
        $this->discounted_price = CustomHelper::calculateDiscountedPrice($this->total, $this->getPointsDiscountApplied());

        return $this->discounted_price;
    }

    public function getPointsGained()
    {
        if ($this->isDiscountApplied()) {
            $this->calculateDiscountedPrice();
            return ($this->base_points * $this->multiplier) * $this->discounted_price;
        }
        return ($this->base_points * $this->multiplier) * $this->total;
    }

    public function getUserPoints()
    {
        return $this->user_points;
    }

    public function getPointsMultiplier()
    {
        return $this->multiplier;
    }

    public function getPointsExhanged(): int
    {
        return session('points_exchanged', 0);
    }

    public function getPointsDiscountApplied()
    {
        return session('points_discount_applied', 0);
    }

    public function displayUserGroup()
    {
        return empty($this->group_title) ? '' : $this->group_title;
    }
}
