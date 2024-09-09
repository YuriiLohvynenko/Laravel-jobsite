<?php

namespace App\Console\Commands;

use App\Models\Listing;
use App\Notifications\ListingExpire;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendListingExpireNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listings:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send expiration notifications to the users daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $listings = Listing::whereDate('date_time', Carbon::today())->get();
       if ($listings->count() > 0) {
           foreach ($listings as $listing) {
                $user = $listing->user;
                $user->notify(new ListingExpire($listing));
           }
       }
    }
}
