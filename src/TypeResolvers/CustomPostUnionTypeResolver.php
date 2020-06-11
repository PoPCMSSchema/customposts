<?php

declare(strict_types=1);

namespace PoP\Content\TypeResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\AbstractUnionTypeResolver;
use PoP\Content\FieldInterfaces\CustomPostFieldInterfaceResolver;
use PoP\Content\TypeDataLoaders\CustomPostUnionTypeDataLoader;

class CustomPostUnionTypeResolver extends AbstractUnionTypeResolver
{
    public const NAME = 'CustomPostUnion';

    public function getTypeName(): string
    {
        return self::NAME;
    }

    public function getSchemaTypeDescription(): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $translationAPI->__('Union of \'content entity\' type resolvers', 'content');
    }

    public function getTypeDataLoaderClass(): string
    {
        return CustomPostUnionTypeDataLoader::class;
    }

    public function getSchemaTypeInterfaceClass(): ?string
    {
        return CustomPostFieldInterfaceResolver::class;
    }
}
