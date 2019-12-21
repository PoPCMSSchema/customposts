<?php
namespace PoP\Content\TypeDataLoaders;

use PoP\ComponentModel\TypeDataLoaders\AbstractUnionTypeDataLoader;
use PoP\Content\TypeResolvers\ContentEntityUnionTypeResolver;

class ContentEntityUnionTypeDataLoader extends AbstractUnionTypeDataLoader
{
    protected function getUnionTypeResolverClass(): string
    {
        return ContentEntityUnionTypeResolver::class;
    }
}
