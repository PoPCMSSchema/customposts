<?php

declare(strict_types=1);

namespace PoP\Content\FieldResolvers;

use PoP\Content\TypeAPIs\ContentEntityTypeAPIInterface;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Content\Facades\ContentEntityTypeAPIFacade;
use PoP\Content\FieldInterfaces\ContentEntityFieldInterfaceResolver;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\LooseContracts\Facades\NameResolverFacade;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;

abstract class AbstractContentEntityFieldResolver extends AbstractDBDataFieldResolver
{
    public static function getFieldNamesToResolve(): array
    {
        return [];
    }

    public static function getImplementedInterfaceClasses(): array
    {
        return [
            ContentEntityFieldInterfaceResolver::class,
        ];
    }

    protected function getContentEntityTypeAPI(): ContentEntityTypeAPIInterface
    {
        $contentEntityTypeAPI = ContentEntityTypeAPIFacade::getInstance();
        return $contentEntityTypeAPI;
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $contentEntityTypeAPI = $this->getContentEntityTypeAPI();
        switch ($fieldName) {
            case 'content':
                $value = $contentEntityTypeAPI->getContent($resultItem);
                return HooksAPIFacade::getInstance()->applyFilters('pop_content', $value, $typeResolver->getID($resultItem));

            case 'url':
                return $contentEntityTypeAPI->getPermalink($resultItem);

            case 'status':
                return $contentEntityTypeAPI->getStatus($resultItem);

            case 'isStatus':
                return $fieldArgs['status'] == $contentEntityTypeAPI->getStatus($resultItem);

            case 'date':
                $format = $fieldArgs['format'] ?? $cmsengineapi->getOption(NameResolverFacade::getInstance()->getName('popcms:option:dateFormat'));
                return $cmsengineapi->getDate($format, $contentEntityTypeAPI->getPublishedDate($resultItem));

            case 'datetime':
                // If it is the current year, don't add the year. Otherwise, do
                // 15 Jul, 21:47 or // 15 Jul 2018, 21:47
                $date = $contentEntityTypeAPI->getPublishedDate($resultItem);
                $format = $fieldArgs['format'];
                if (!$format) {
                    $format = ($cmsengineapi->getDate('Y', $date) == date('Y')) ? 'j M, H:i' : 'j M Y, H:i';
                }
                return $cmsengineapi->getDate($format, $date);

            case 'title':
                return $contentEntityTypeAPI->getTitle($resultItem);

            case 'excerpt':
                return $contentEntityTypeAPI->getExcerpt($resultItem);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
