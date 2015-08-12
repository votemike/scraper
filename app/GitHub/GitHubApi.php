<?php namespace Scraper\GitHub;

use GuzzleHttp\Client;
use Illuminate\Http\Response;

class GitHubApi {
    protected $client;
    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function username($username) {
        $username = urlencode($username);
        $response = $this->client->get('users/'.$username, ['http_errors' => false]);

        if($response->getStatusCode() == Response::HTTP_OK) {
            return User::fromApi(json_decode($response->getBody()));
        }

        return false;
    }
}