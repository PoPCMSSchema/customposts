<?php
namespace PoP\Content\FieldResolvers;

use PoP\Content\TypeAPIs\ContentEntryTypeAPIInterface;
use PoP\Content\TypeAPIs\ContentEntityTypeAPIInterface;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Content\FieldResolvers\AbstractContentEntryFieldResolver;
use PoP\Content\FieldInterfaces\ContentEntityFieldInterfaceResolver;

abstract class AbstractContentEntityFieldResolver extends AbstractContentEntryFieldResolver
{
    public static function getFieldNamesToResolve(): array
    {
        return [];
    }

    public static function getImplementedInterfaceClasses(): array
    {
        return array_merge(
            parent::getImplementedInterfaceClasses(),
            [
                ContentEntityFieldInterfaceResolver::class,
            ]
        );
    }

    abstract protected function getContentEntityTypeAPI(): ContentEntityTypeAPIInterface;

    protected function getContentEntryTypeAPI(): ContentEntryTypeAPIInterface
    {
        return $this->getContentEntityTypeAPI();
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $contentEntityTypeAPI = $this->getContentEntityTypeAPI();
        switch ($fieldName) {
            case 'title':
                return $contentEntityTypeAPI->getTitle($resultItem);

            case 'excerpt':
                return $contentEntityTypeAPI->getExcerpt($resultItem);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
