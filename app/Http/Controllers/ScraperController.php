<?php

namespace Scraper\Http\Controllers;

use Illuminate\Http\Request;

use stdClass;
use Scraper\GooglePlus\GooglePlus;
use Scraper\Http\Requests;
use Scraper\Twitter\Twitter;
use Scraper\GitHub\GitHub;

class ScraperController extends Controller
{
    public $user;
    public $potentialUsers;

    public function index(Request $request) {
        //Create a base user, assume github username is correct
        //@TODO can't assume this
        $this->user = new stdClass();
        $this->searchUsername($request->input('username'));

        $this->searchName($this->user->name);

        $this->searchPotentialUsers();
        dd($this->user);
        return view('welcome');
    }

    private function searchName($name) {
        $twitters = Twitter::search($name);
        if($twitters) {
            $this->potentialUsers = array_merge($this->potentialUsers, $twitters);
        }
        $googleplusses = GooglePlus::search($name);
        if($googleplusses) {
            $this->potentialUsers = array_merge($this->potentialUsers, $googleplusses);
        }
    }

    private function searchUsername($username) {
        $github = GitHub::username($username);
        $this->mergeUser($github);
        $twitter = Twitter::fromUsername($username);
        if($twitter) {
            $this->potentialUsers[] = $twitter;
            $this->searchPotentialUsers();
        }
        $googlePlus = GooglePlus::userId($username);
        if($googlePlus) {
            $this->potentialUsers[] = $googlePlus;
            $this->searchPotentialUsers();
        }
    }

    private function mergeUser($user) {
        $atts = get_object_vars($user);
        foreach($atts as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    private function setAttribute($key, $value) {
        if(empty($value)) {
            return;
        }

        if(!isset($this->user->$key)) {
            $this->user->$key = $value;
            return;
        }

        if($this->user->$key == $value) {
            return;
        }

        //this won't work for arrays....

        dd('Current value '.$this->user->$key.' and value '.$value.' don\'t match!');
    }

    private function searchPotentialUsers() {
        foreach($this->potentialUsers as $key => $potential) {
            if($this->checkPotentialUserShouldBeMerged($potential)) {
                unset($this->potentialUsers[$key]);
            }
        }
    }

    private function checkPotentialUserShouldBeMerged($potentialUser) {
        $matching = 0;
        $atts = get_object_vars($potentialUser);
        foreach($atts as $key => $value) {
            if(isset($this->user->$key) && $this->user->$key == $value && !empty($value)) {
                $matching++;
            }
        }
        if($matching > 2) {
            $this->mergeUser($potentialUser);
            return true;
        }

        return false;
    }
}