<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Glide\ServerFactory;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use App\Http\Glide\LaravelResponseFactory;

class GlideServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('League\Glide\Server', function ($app) {
            // Source filesystem
            $source = new Filesystem(
                new LocalFilesystemAdapter(storage_path('app/public'))
            );

            // Cache filesystem
            $cache = new Filesystem(
                new LocalFilesystemAdapter(storage_path('app/glide-cache'))
            );

            return ServerFactory::create([
                'source' => $source,
                'cache' => $cache,
                'source_path_prefix' => 'uploads',
                'cache_path_prefix' => '',
                'base_url' => 'img',
                'max_image_size' => 2000 * 2000,
                'presets' => [
                    'avatar_thumb' => [
                        'w' => 80,
                        'h' => 80,
                        'fit' => 'crop',
                        'fm' => 'webp',
                    ],
                    'avatar_medium' => [
                        'w' => 200,
                        'h' => 200,
                        'fit' => 'crop',
                        'fm' => 'webp',
                    ],
                    'avatar_large' => [
                        'w' => 400,
                        'h' => 400,
                        'fit' => 'crop',
                        'fm' => 'webp',
                    ],
                ],
                'response' => new LaravelResponseFactory(),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}