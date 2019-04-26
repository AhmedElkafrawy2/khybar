<?php

namespace App\Providers;

use App\Setting;
use App\Comment;
use App\ContactUs;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if ( Schema::hasTable('settings') )
        {
            view()->share([
                'settings' => Setting::find(1)
            ]);
        }
        if ( Schema::hasTable('comments') )
        {
            view()->share([
                'unreadcommentscount' => Comment::where('reviewed', 0)->get()->count()
            ]);
        }
        if ( Schema::hasTable('contact_uses') )
        {
            view()->share([
                'unreadcontactusescount' => ContactUs::where('reviewed', 0)->get()->count()
            ]);
        }

        if ( App::environment('local') )
        {
            view()->share([
                'path' => 'storage/'
            ]);
        }
        elseif ( App::environment('server') )
        {
            view()->share([
                'path' => 'storage/app/public/'
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
