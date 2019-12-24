<?php
namespace PoP\Content\FieldInterfaces;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\LooseContracts\Facades\NameResolverFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Content\FieldInterfaces\ContentEntryFieldInterfaceResolver;

class ContentEntityFieldInterfaceResolver extends ContentEntryFieldInterfaceResolver
{
    public const NAME = 'ContentEntity';
    public function getInterfaceName(): string
    {
        return self::NAME;
    }

    public static function getFieldNamesToImplement(): array
    {
        return array_merge(
            [
                'title',
                'excerpt',
            ],
            parent::getFieldNamesToImplement()
        );
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'title' => SchemaDefinition::TYPE_STRING,
            'excerpt' => SchemaDefinition::TYPE_STRING,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'title' => $translationAPI->__('Post title', 'content'),
            'excerpt' => $translationAPI->__('Post excerpt', 'content'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }
}
