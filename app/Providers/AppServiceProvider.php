<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('displayStatus', function ($status) {
            $toReturn = "if ($status == 0) {
                echo html_entity_decode('<span class=\'bg-merah-transparan rounded p-1 pl-2 pr-2\'>Ditolak</span>');
            } else if ($status == 1) {
                echo html_entity_decode('<span class=\'bg-hijau-transparan rounded p-1 pl-2 pr-2\'>Disetujui</span>');
            } else if($status == 2) {
                echo html_entity_decode('<span class=\'bg-kuning-transparan rounded p-1 pl-2 pr-2\'>Delay</span>');
            }";

            return "<?php $toReturn ?>";
        });
    }
}
