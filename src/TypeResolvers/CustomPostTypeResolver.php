<?php

declare(strict_types=1);

namespace PoP\CustomPosts\TypeResolvers;

use PoP\CustomPosts\TypeDataLoaders\CustomPostTypeDataLoader;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\CustomPosts\TypeResolvers\AbstractCustomPostTypeResolver;

/**
 * Class to be used only when a generic CustomPost type is good enough.
 * Otherwise, a specific type for the entity should be employed.
 */
class CustomPostTypeResolver extends AbstractCustomPostTypeResolver
{
    public const NAME = 'CustomPost';

    public function getTypeName(): string
    {
        return self::NAME;
    }

    public function getSchemaTypeDescription(): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $translationAPI->__('Representation of a custom post', 'customposts');
    }

    public function getTypeDataLoaderClass(): string
    {
        return CustomPostTypeDataLoader::class;
    }
}
