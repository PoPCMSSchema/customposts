<?php

declare(strict_types=1);

namespace PoP\CustomPosts\TypeDataLoaders;

use PoP\ComponentModel\TypeDataLoaders\AbstractUnionTypeDataLoader;
use PoP\CustomPosts\TypeResolvers\CustomPostUnionTypeResolver;

class CustomPostUnionTypeDataLoader extends AbstractUnionTypeDataLoader
{
    protected function getUnionTypeResolverClass(): string
    {
        return CustomPostUnionTypeResolver::class;
    }
}
