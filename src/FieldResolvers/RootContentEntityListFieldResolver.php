<?php

declare(strict_types=1);

namespace PoP\Content\FieldResolvers;

use PoP\Engine\TypeResolvers\RootTypeResolver;

class RootContentEntityListFieldResolver extends AbstractContentEntityListFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(RootTypeResolver::class);
    }
}
