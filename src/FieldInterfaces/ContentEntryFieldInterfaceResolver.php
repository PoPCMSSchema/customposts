<?php
namespace PoP\Content\FieldInterfaces;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\LooseContracts\Facades\NameResolverFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\EnumTypeSchemaDefinitionResolverTrait;
use PoP\ComponentModel\FieldResolvers\AbstractSchemaFieldInterfaceResolver;

class ContentEntryFieldInterfaceResolver extends AbstractSchemaFieldInterfaceResolver
{
    use EnumTypeSchemaDefinitionResolverTrait;

    public const NAME = 'ContentEntry';
    public const STATUSES = [
        \POP_POSTSTATUS_PUBLISHED,
        \POP_POSTSTATUS_PENDING,
        \POP_POSTSTATUS_DRAFT,
        \POP_POSTSTATUS_TRASH,
        'trashed',
    ];
    public function getInterfaceName(): string
    {
        return self::NAME;
    }

    public function getSchemaInterfaceDescription(): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $translationAPI->__('Entities representing publishable \'content\'', 'content');
    }

    public static function getFieldNamesToImplement(): array
    {
        return [
            'content',
            'url',
            'status',
            'isStatus',
            'date',
            'datetime',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'content' => SchemaDefinition::TYPE_STRING,
            'url' => SchemaDefinition::TYPE_URL,
            'status' => SchemaDefinition::TYPE_ENUM,
            'isStatus' => SchemaDefinition::TYPE_BOOL,
            'date' => SchemaDefinition::TYPE_DATE,
            'datetime' => SchemaDefinition::TYPE_DATE,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'content' => $translationAPI->__('Post content', 'content'),
            'url' => $translationAPI->__('Post URL', 'content'),
            'postType' => $translationAPI->__('Post type', 'content'),
            'status' => $translationAPI->__('Post status', 'content'),
            'isStatus' => $translationAPI->__('Is the post in the given status?', 'content'),
            'date' => $translationAPI->__('Post published date', 'content'),
            'datetime' => $translationAPI->__('Post published date and time', 'content'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function getSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): array
    {
        $schemaFieldArgs = parent::getSchemaFieldArgs($typeResolver, $fieldName);
        $translationAPI = TranslationAPIFacade::getInstance();
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        switch ($fieldName) {
            case 'date':
                return array_merge(
                    $schemaFieldArgs,
                    [
                        [
                            SchemaDefinition::ARGNAME_NAME => 'format',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_STRING,
                            SchemaDefinition::ARGNAME_DESCRIPTION => sprintf(
                                $translationAPI->__('Date format, as defined in %s', 'content'),
                                'https://www.php.net/manual/en/function.date.php'
                            ),
                            SchemaDefinition::ARGNAME_DEFAULT_VALUE => $cmsengineapi->getOption(NameResolverFacade::getInstance()->getName('popcms:option:dateFormat')),
                        ],
                    ]
                );

            case 'datetime':
                return array_merge(
                    $schemaFieldArgs,
                    [
                        [
                            SchemaDefinition::ARGNAME_NAME => 'format',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_STRING,
                            SchemaDefinition::ARGNAME_DESCRIPTION => sprintf(
                                $translationAPI->__('Date and time format, as defined in %s. Default value: \'%s\' (for current year date) or \'%s\' (otherwise)', 'content'),
                                'https://www.php.net/manual/en/function.date.php',
                                'j M, H:i',
                                'j M Y, H:i'
                            ),
                        ],
                    ]
                );

            case 'isStatus':
                return array_merge(
                    $schemaFieldArgs,
                    [
                        [
                            SchemaDefinition::ARGNAME_NAME => 'status',
                            SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_ENUM,
                            SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('The status to check if the post has', 'content'),
                            SchemaDefinition::ARGNAME_ENUMVALUES => [
                                \POP_POSTSTATUS_PUBLISHED => [
                                    SchemaDefinition::ARGNAME_NAME => \POP_POSTSTATUS_PUBLISHED,
                                ],
                                \POP_POSTSTATUS_PENDING => [
                                    SchemaDefinition::ARGNAME_NAME => \POP_POSTSTATUS_PENDING,
                                ],
                                \POP_POSTSTATUS_DRAFT => [
                                    SchemaDefinition::ARGNAME_NAME => \POP_POSTSTATUS_DRAFT,
                                ],
                                \POP_POSTSTATUS_TRASH => [
                                    SchemaDefinition::ARGNAME_NAME => \POP_POSTSTATUS_TRASH,
                                ],
                                'trashed' => [
                                    SchemaDefinition::ARGNAME_NAME => 'trashed',
                                    SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('Published content', 'content'),
                                    SchemaDefinition::ARGNAME_DEPRECATED => true,
                                    SchemaDefinition::ARGNAME_DEPRECATIONDESCRIPTION => sprintf(
                                        $translationAPI->__('Use \'%s\' instead', 'content'),
                                        \POP_POSTSTATUS_TRASH
                                    ),
                                ],
                            ],
                            SchemaDefinition::ARGNAME_MANDATORY => true,
                        ],
                    ]
                );
        }

        return $schemaFieldArgs;
    }

    protected function getSchemaDefinitionEnumValues(TypeResolverInterface $typeResolver, string $fieldName): ?array
    {
        switch ($fieldName) {
            case 'status':
                return self::STATUSES;
        }
        return null;
    }

    protected function getSchemaDefinitionEnumValueDeprecationDescriptions(TypeResolverInterface $typeResolver, string $fieldName): ?array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        switch ($fieldName) {
            case 'status':
                return [
                    'trashed' => sprintf(
                        $translationAPI->__('Using \'%s\' instead', 'content'),
                        \POP_POSTSTATUS_TRASH
                    ),
                ];
        }
        return null;
    }

    protected function getSchemaDefinitionEnumValueDescriptions(TypeResolverInterface $typeResolver, string $fieldName): ?array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        switch ($fieldName) {
            case 'status':
                return [
                    \POP_POSTSTATUS_PUBLISHED => $translationAPI->__('Published content', 'content'),
                    \POP_POSTSTATUS_PENDING => $translationAPI->__('Pending content', 'content'),
                    \POP_POSTSTATUS_DRAFT => $translationAPI->__('Draft content', 'content'),
                    \POP_POSTSTATUS_TRASH => $translationAPI->__('Trashed content', 'content'),
                    'trashed' => $translationAPI->__('Trashed content', 'content'),
                ];
        }
        return null;
    }
}
