<?php

declare(strict_types=1);

namespace PoP\Content\TypeDataLoaders;

use PoP\ComponentModel\TypeDataLoaders\AbstractUnionTypeDataLoader;
use PoP\Content\TypeResolvers\CustomPostUnionTypeResolver;

class CustomPostUnionTypeDataLoader extends AbstractUnionTypeDataLoader
{
    protected function getUnionTypeResolverClass(): string
    {
        return CustomPostUnionTypeResolver::class;
    }
}
