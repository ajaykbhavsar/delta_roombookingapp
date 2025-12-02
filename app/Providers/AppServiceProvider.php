<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Location;
use App\Models\Room;
use App\Models\RoomType;
use App\Policies\BookingPolicy;
use App\Policies\LocationPolicy;
use App\Policies\RoomPolicy;
use App\Policies\RoomTypePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Location::class, LocationPolicy::class);
        Gate::policy(Room::class, RoomPolicy::class);
        Gate::policy(RoomType::class, RoomTypePolicy::class);
        Gate::policy(Booking::class, BookingPolicy::class);
    }
}
