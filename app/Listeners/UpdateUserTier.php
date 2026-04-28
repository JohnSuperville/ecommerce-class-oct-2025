<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\tier\Tier;
use App\Models\User;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class UpdateUserTier
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPaid $event): void
    {
        if ($event->order->payment_status = 'paid') {
            // Find user
            $user = User::withOnly('tier')->where('id', $event->order->user_id)->first();
            // Get sum of total user orders spent.
            $sum = $user->orders()->where('payment_status', 'paid')->sum('total');
            // Get tier based on sum, total user orders.
            $tier_id = Tier::where('spending_range', '<=', $sum)->orderBy('spending_range', 'desc')->limit(1)->first()->id ?? 1;
            // Update user table after Tier determination.
            if ($user->tier_id != $tier_id) {
                $user->tier_id = $tier_id;
                $user->save();
            }
        }
    }
}
