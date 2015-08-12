<?php

namespace Scraper\GooglePlus;

use Scraper\Scraper\ApiUser;

class User implements ApiUser
{
    public static function fromApi($object) {
        $user = new static();
        $user->name = $object->name->givenName.' '.$object->name->familyName;
        $user->id = $object->id;
        if(isset($object->gender)) {
            $user->gender = $object->gender;
        }
        if(isset($object->occupation)) {
            $user->occupation = $object->occupation;
        }
        $user->photos[] = $object->image->url;

        return $user;
    }
}