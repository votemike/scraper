<?php

namespace Scraper\Twitter;

use Scraper\Scraper\ApiUser;

class User implements ApiUser
{
    public static function fromApi($object) {
        $user = new static();
        $user->name = $object->name;
        $user->username = $object->screen_name;
        $user->location = $object->location;
        $user->language = $object->lang;
        $user->photos[] = $object->profile_image_url;

        return $user;
    }
}