<?php

declare(strict_types=1);

namespace PoP\CustomPosts\FieldResolvers;

use PoP\CustomPosts\TypeResolvers\AbstractCustomPostTypeResolver;
use PoP\CustomPosts\FieldResolvers\AbstractCustomPostFieldResolver;

class CustomPostFieldResolver extends AbstractCustomPostFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return [
            AbstractCustomPostTypeResolver::class,
        ];
    }
}
