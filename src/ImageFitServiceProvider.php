<?php

namespace Amir2b\ImageFit;

use Illuminate\Support\ServiceProvider;
use Route;

class ImageFitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../files/config.php' => config_path('image-fit.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../files/config.php', 'image-fit'
        );

        if (! $this->app->routesAreCached()) {
            Route::get($this->app['config']->get('image-fit.prefix') . '{image}{type}{width}x{height}.{ext}', 'Amir2b\ImageFit\ImageController@create')->where(['image' => '(/[\w\-\.\(\)]+)+', 'type' => '_|-', 'width' => '\d+', 'height' => '\d+', 'ext' => 'jpe?g|JPE?G|png|gif']);
        }

        require_once  __DIR__ . '../files/helpers.php';
    }
}
