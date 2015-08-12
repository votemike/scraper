<?php namespace Scraper\GitHub;

use Illuminate\Support\Facades\Facade;

class GitHub extends Facade {
    public static function getFacadeAccessor() {
        return 'github';
    }
}