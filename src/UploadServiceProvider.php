<?php

namespace InternetGuru\LaravelUpload;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/upload.php', 'upload');
    }

    public function boot()
    {
        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'ig-upload');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'upload');

    }
}
