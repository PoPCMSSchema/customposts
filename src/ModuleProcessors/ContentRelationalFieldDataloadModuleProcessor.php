<?php

declare(strict_types=1);

namespace PoP\Content\ModuleProcessors;

use PoP\Content\TypeResolvers\ContentEntityUnionTypeResolver;
use PoP\QueriedObject\ModuleProcessors\QueriedDBObjectModuleProcessorTrait;
use PoP\API\ModuleProcessors\AbstractRelationalFieldDataloadModuleProcessor;
use PoP\ComponentModel\QueryInputOutputHandlers\ListQueryInputOutputHandler;

class ContentRelationalFieldDataloadModuleProcessor extends AbstractRelationalFieldDataloadModuleProcessor
{
    use QueriedDBObjectModuleProcessorTrait;

    public const MODULE_DATALOAD_RELATIONALFIELDS_SINGLECONTENT = 'dataload-relationalfields-singlecontent';
    public const MODULE_DATALOAD_RELATIONALFIELDS_CONTENTLIST = 'dataload-relationalfields-contentlist';
    public const MODULE_DATALOAD_RELATIONALFIELDS_CONTENTCOUNT = 'dataload-relationalfields-contentcount';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_SINGLECONTENT],
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_CONTENTLIST],
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_CONTENTCOUNT],
        );
    }

    public function getDBObjectIDOrIDs(array $module, array &$props, &$data_properties)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_SINGLECONTENT:
                return $this->getQueriedDBObjectID($module, $props, $data_properties);
        }

        return parent::getDBObjectIDOrIDs($module, $props, $data_properties);
    }

    public function getTypeResolverClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_SINGLECONTENT:
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CONTENTLIST:
                return ContentEntityUnionTypeResolver::class;
        }

        return parent::getTypeResolverClass($module);
    }

    public function getQueryInputOutputHandlerClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CONTENTLIST:
                return ListQueryInputOutputHandler::class;
        }

        return parent::getQueryInputOutputHandlerClass($module);
    }

    public function getFilterSubmodule(array $module): ?array
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CONTENTLIST:
                return [
                    ContentFilterInnerModuleProcessor::class,
                    ContentFilterInnerModuleProcessor::MODULE_FILTERINNER_CONTENTS
                ];
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CONTENTCOUNT:
                return [
                    ContentFilterInnerModuleProcessor::class,
                    ContentFilterInnerModuleProcessor::MODULE_FILTERINNER_CONTENTCOUNT
                ];
        }

        return parent::getFilterSubmodule($module);
    }
}
