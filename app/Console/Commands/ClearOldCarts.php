<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CartItem;
use Illuminate\Support\Carbon;

class ClearOldCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:clear-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear guest carts older than 48 hours and authenticated user carts older than 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $guestItemsDeleted = CartItem::whereNull('user_id')
            ->where('updated_at', '<', Carbon::now()->subHours(48))
            ->delete();

        $userItemsDeleted = CartItem::whereNotNull('user_id')
            ->where('updated_at', '<', Carbon::now()->subDays(30))
            ->delete();

        $this->info("Cleared {$guestItemsDeleted} guest cart items successfully.");
        $this->info("Cleared {$userItemsDeleted} authenticated cart items successfully.");
    }
}
