<?php

declare(strict_types=1);

namespace PoP\CustomPosts\FieldResolvers;

use PoP\CustomPosts\ComponentConfiguration;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoP\ComponentModel\TypeResolvers\UnionTypeHelpers;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\CustomPosts\TypeResolvers\CustomPostUnionTypeResolver;
use PoP\ComponentModel\FieldResolvers\AbstractQueryableFieldResolver;
use PoP\CustomPosts\ModuleProcessors\ContentRelationalFieldDataloadModuleProcessor;
use PoP\CustomPosts\Types\Status;

abstract class AbstractCustomPostListFieldResolver extends AbstractQueryableFieldResolver
{
    public static function getFieldNamesToResolve(): array
    {
        return [
            'customPosts',
            'customPostCount',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'customPosts' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
            'customPostCount' => SchemaDefinition::TYPE_INT,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function isSchemaFieldResponseNonNullable(TypeResolverInterface $typeResolver, string $fieldName): bool
    {
        switch ($fieldName) {
            case 'customPosts':
            case 'customPostCount':
                return true;
        }
        return parent::isSchemaFieldResponseNonNullable($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'customPosts' => $translationAPI->__('Custom posts', 'pop-posts'),
            'customPostCount' => $translationAPI->__('Number of custom posts', 'pop-posts'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function getSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): array
    {
        $schemaFieldArgs = parent::getSchemaFieldArgs($typeResolver, $fieldName);
        switch ($fieldName) {
            case 'customPosts':
            case 'customPostCount':
                return array_merge(
                    $schemaFieldArgs,
                    $this->getFieldArgumentsSchemaDefinitions($typeResolver, $fieldName)
                );
        }
        return $schemaFieldArgs;
    }

    public function enableOrderedSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): bool
    {
        switch ($fieldName) {
            case 'customPosts':
            case 'customPostCount':
                return false;
        }
        return parent::enableOrderedSchemaFieldArgs($typeResolver, $fieldName);
    }

    protected function getFieldDefaultFilterDataloadingModule(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?array
    {
        switch ($fieldName) {
            case 'customPostCount':
                return [
                    ContentRelationalFieldDataloadModuleProcessor::class,
                    ContentRelationalFieldDataloadModuleProcessor::MODULE_DATALOAD_RELATIONALFIELDS_CONTENTCOUNT
                ];
        }
        return parent::getFieldDefaultFilterDataloadingModule($typeResolver, $fieldName, $fieldArgs);
    }

    protected function getQuery(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): array
    {
        switch ($fieldName) {
            case 'customPosts':
                return [
                    'limit' => ComponentConfiguration::getCustomPostListDefaultLimit(),
                    'types-from-union-resolver-class' => CustomPostUnionTypeResolver::class,
                    'post-status' => [
                        Status::PUBLISHED,
                    ],
                ];
            case 'customPostCount':
                return [
                    'types-from-union-resolver-class' => CustomPostUnionTypeResolver::class,
                    'post-status' => [
                        Status::PUBLISHED,
                    ],
                ];
        }
        return [];
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        switch ($fieldName) {
            case 'customPosts':
                $query = $this->getQuery($typeResolver, $resultItem, $fieldName, $fieldArgs);
                $options = [
                    'return-type' => POP_RETURNTYPE_IDS,
                ];
                $this->addFilterDataloadQueryArgs($options, $typeResolver, $fieldName, $fieldArgs);
                return $customPostTypeAPI->getCustomPosts($query, $options);
            case 'customPostCount':
                $query = $this->getQuery($typeResolver, $resultItem, $fieldName, $fieldArgs);
                $options = [];
                $this->addFilterDataloadQueryArgs($options, $typeResolver, $fieldName, $fieldArgs);
                return $customPostTypeAPI->getCustomPostCount($query, $options);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldTypeResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'customPosts':
                return UnionTypeHelpers::getUnionOrTargetTypeResolverClass(CustomPostUnionTypeResolver::class);
        }

        return parent::resolveFieldTypeResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}
