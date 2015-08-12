<?php namespace Scraper\GitHub;

use Config;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind('github', function() {
            $client = new Client(['base_uri' => 'https://api.github.com/']);
            return new GitHubApi($client);
        });
    }
}