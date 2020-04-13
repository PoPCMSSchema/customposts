<?php
namespace PoP\Content\TypeResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\AbstractUnionTypeResolver;
use PoP\Content\FieldInterfaces\ContentEntityFieldInterfaceResolver;
use PoP\Content\TypeDataLoaders\ContentEntityUnionTypeDataLoader;

class ContentEntityUnionTypeResolver extends AbstractUnionTypeResolver
{
    public const NAME = 'ContentEntityUnion';

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
        return ContentEntityUnionTypeDataLoader::class;
    }

    public function getSchemaTypeInterfaceClass(): ?string
    {
        return ContentEntityFieldInterfaceResolver::class;
    }
}
