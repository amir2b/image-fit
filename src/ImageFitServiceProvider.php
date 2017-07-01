<?php

namespace Amir2b\ImageFit;

use Illuminate\Support\ServiceProvider;

class ImageFitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../files/config.php' => config_path('image-fit.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../assets' => public_path('vendor/image-fit'),
        ], 'public');

        // HTTP routing
        if ((double) $this->app->version() >= 5.2) {
            $this->app['router']->get($this->app['config']->get('image-fit.prefix') . '{image}{type}{width}x{height}.{ext}', '\Amir2b\ImageFit\ImageController@create')
                ->where(['image' => '(/[\w\-\.\(\)]+)+', 'type' => '_|-', 'width' => '\d+', 'height' => '\d+', 'ext' => 'jpe?g|png|gif|JPE?G'])
                ->middleware('web');
        } else {
            $this->app['router']->get($this->app['config']->get('image-fit.prefix') . '{image}{type}{width}x{height}.{ext}', '\Amir2b\ImageFit\ImageController@create')
                ->where(['image' => '(/[\w\-\.\(\)]+)+', 'type' => '_|-', 'width' => '\d+', 'height' => '\d+', 'ext' => 'jpe?g|png|gif|JPE?G']);
        }
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

        require_once  __DIR__ . '/../files/helpers.php';
    }
}
