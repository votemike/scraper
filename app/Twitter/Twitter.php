<?php namespace Scraper\Twitter;

use Illuminate\Support\Facades\Facade;

class Twitter extends Facade {
    public static function getFacadeAccessor() {
        return 'twitter';
    }
}