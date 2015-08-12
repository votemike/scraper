<?php namespace Scraper\GooglePlus;

use Config;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class GooglePlusServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind('googleplus', function() {
            $client = new Client(['base_uri' => 'https://www.googleapis.com/plus/v1/']);
            return new GooglePlusApi($client);
        });
    }
}