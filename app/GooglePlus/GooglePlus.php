<?php namespace Scraper\GooglePlus;

use Illuminate\Support\Facades\Facade;

class GooglePlus extends Facade {
    public static function getFacadeAccessor() {
        return 'googleplus';
    }
}