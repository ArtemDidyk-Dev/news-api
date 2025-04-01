<?php

declare(strict_types=1);

namespace App\Serializer;

class AccessGroup
{
    //User
    public const USER_CREATE = 'user:create';
    public const USER_SHOW = 'user:show';

    //Post
    public const POST_CREATE = 'post:create';
    public const POST_SHOW = 'post:show';
}
