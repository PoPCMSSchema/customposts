<?php

declare(strict_types=1);

namespace PoP\CustomPosts\FieldResolvers;

use PoP\Engine\TypeResolvers\RootTypeResolver;

class RootCustomPostListFieldResolver extends AbstractCustomPostListFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(RootTypeResolver::class);
    }
}
