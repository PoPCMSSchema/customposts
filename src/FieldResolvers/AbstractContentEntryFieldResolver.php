<?php
namespace PoP\Content\FieldResolvers;

use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\LooseContracts\Facades\NameResolverFacade;
use PoP\Content\TypeAPIs\ContentEntryTypeAPIInterface;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\Content\FieldInterfaces\ContentEntryFieldInterfaceResolver;

abstract class AbstractContentEntryFieldResolver extends AbstractDBDataFieldResolver
{
    public static function getFieldNamesToResolve(): array
    {
        return [];
    }

    public static function getImplementedInterfaceClasses(): array
    {
        return [
            ContentEntryFieldInterfaceResolver::class,
        ];
    }

    abstract protected function getContentEntryTypeAPI(): ContentEntryTypeAPIInterface;

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $contentEntryTypeAPI = $this->getContentEntryTypeAPI();
        switch ($fieldName) {
            case 'content':
                $value = $contentEntryTypeAPI->getContent($resultItem);
                return HooksAPIFacade::getInstance()->applyFilters('pop_content', $value, $typeResolver->getID($resultItem));

            case 'url':
                return $contentEntryTypeAPI->getPermalink($resultItem);

            case 'status':
                return $contentEntryTypeAPI->getStatus($resultItem);

            case 'isStatus':
                return $fieldArgs['status'] == $contentEntryTypeAPI->getStatus($resultItem);

            case 'date':
                $format = $fieldArgs['format'] ?? $cmsengineapi->getOption(NameResolverFacade::getInstance()->getName('popcms:option:dateFormat'));
                return $cmsengineapi->getDate($format, $contentEntryTypeAPI->getPublishedDate($resultItem));

            case 'datetime':
                // If it is the current year, don't add the year. Otherwise, do
                // 15 Jul, 21:47 or // 15 Jul 2018, 21:47
                $date = $contentEntryTypeAPI->getPublishedDate($resultItem);
                $format = $fieldArgs['format'];
                if (!$format) {
                    $format = ($cmsengineapi->getDate('Y', $date) == date('Y')) ? 'j M, H:i' : 'j M Y, H:i';
                }
                return $cmsengineapi->getDate($format, $date);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
