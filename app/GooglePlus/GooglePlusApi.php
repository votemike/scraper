<?php namespace Scraper\GooglePlus;

use Config;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class GooglePlusApi {
    protected $client;
    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function search($searchTerm) {
        $searchTerm = urlencode($searchTerm);
        $response = $this->client->get('people/', ['query' => 'query='.$searchTerm.'&maxResults=5&key='.Config::get('googleplus.private_key'), 'http_errors' => false]);

        if($response->getStatusCode() == Response::HTTP_OK) {
            $responseObject = json_decode($response->getBody());
            $users = [];
            foreach($responseObject->items as $ob) {
                $users[] = $this->userId($ob->id);
            }
            return $users;
        }

        return false;
    }

    public function userId($id) {
        $response = $this->client->get('people/'.$id, ['query' => 'key='.Config::get('googleplus.private_key'), 'http_errors' => false]);

        if($response->getStatusCode() == Response::HTTP_OK) {
            return User::fromApi(json_decode($response->getBody()));
        }

        return false;

    }
}