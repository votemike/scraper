<?php

namespace Scraper\GitHub;

use Scraper\Scraper\ApiUser;

class User  implements ApiUser
{
    public static function fromApi($object) {
        $user = new static();
        $user->name = $object->name;
        $user->username = $object->login;
        $user->location = $object->location;
        $user->company = $object->company;
        $user->email = $object->email;
        $user->photos[] = $object->avatar_url;
        $user->websites[] = $object->blog;

        return $user;
    }
}