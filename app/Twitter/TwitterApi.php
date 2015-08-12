<?php namespace Scraper\Twitter;

use GuzzleHttp\Client;
use Illuminate\Http\Response;

class TwitterApi {
    protected $client;
    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function fromUsername($username) {
        $username = urlencode($username);
        $response = $this->client->get('users/show.json', ['query' => 'screen_name='.$username, 'http_errors' => false]);

        if($response->getStatusCode() == Response::HTTP_OK) {
            return User::fromApi(json_decode($response->getBody()));
        }

        return false;
    }

    public function search($searchTerm) {
        $searchTerm = urlencode($searchTerm);
        $response = $this->client->get('users/search.json', ['query' => 'q='.$searchTerm, 'http_errors' => false]);

        if($response->getStatusCode() !== Response::HTTP_OK) {
            return false;
        }

        $users = [];
        $objects = json_decode($response->getBody());
        foreach($objects as $u) {
            $users[] = User::fromApi($u);
        }

        return $users;
    }
}