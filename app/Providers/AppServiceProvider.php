<?php

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // Hilangkan wrapper "data"
        JsonResource::withoutWrapping();
    }
}