<?php

namespace InternetGuru\LaravelUpload;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use InternetGuru\LaravelUpload\Http\Livewire\Upload;
use Livewire\Livewire;

class UploadServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Register routes
        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'ig-upload');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'upload');

        // Register Livewire component
        if (class_exists(Livewire::class)) {
            Livewire::component('upload', Upload::class);
        }

        // Publishable resources
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/upload'),
            ], 'upload-views');

            $this->publishes([
                __DIR__ . '/../resources/sass' => resource_path('sass/vendor/upload'),
            ], 'upload-styles');

            $this->publishes([
                __DIR__ . '/../lang' => $this->app->langPath('vendor/upload'),
            ], 'upload-lang');
        }
    }
}
