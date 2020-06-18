<?php

declare(strict_types=1);

namespace PoP\CustomPosts\ModuleProcessors;

use PoP\CustomPosts\TypeResolvers\CustomPostUnionTypeResolver;
use PoP\QueriedObject\ModuleProcessors\QueriedDBObjectModuleProcessorTrait;
use PoP\API\ModuleProcessors\AbstractRelationalFieldDataloadModuleProcessor;
use PoP\ComponentModel\QueryInputOutputHandlers\ListQueryInputOutputHandler;

class CustomPostRelationalFieldDataloadModuleProcessor extends AbstractRelationalFieldDataloadModuleProcessor
{
    use QueriedDBObjectModuleProcessorTrait;

    public const MODULE_DATALOAD_RELATIONALFIELDS_SINGLECUSTOMPOST = 'dataload-relationalfields-singlecustompost';
    public const MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTLIST = 'dataload-relationalfields-custompostlist';
    public const MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTCOUNT = 'dataload-relationalfields-custompostcount';
    public const MODULE_DATALOAD_RELATIONALFIELDS_IMPLEMENTINGCUSTOMPOSTLIST = 'dataload-relationalfields-implementingcustompostlist';
    public const MODULE_DATALOAD_RELATIONALFIELDS_IMPLEMENTINGCUSTOMPOSTCOUNT = 'dataload-relationalfields-implementingcustompostcount';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_SINGLECUSTOMPOST],
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTLIST],
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTCOUNT],
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_IMPLEMENTINGCUSTOMPOSTLIST],
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_IMPLEMENTINGCUSTOMPOSTCOUNT],
        );
    }

    public function getDBObjectIDOrIDs(array $module, array &$props, &$data_properties)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_SINGLECUSTOMPOST:
                return $this->getQueriedDBObjectID($module, $props, $data_properties);
        }

        return parent::getDBObjectIDOrIDs($module, $props, $data_properties);
    }

    public function getTypeResolverClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_SINGLECUSTOMPOST:
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTLIST:
            case self::MODULE_DATALOAD_RELATIONALFIELDS_IMPLEMENTINGCUSTOMPOSTLIST:
                return CustomPostUnionTypeResolver::class;
        }

        return parent::getTypeResolverClass($module);
    }

    public function getQueryInputOutputHandlerClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTLIST:
            case self::MODULE_DATALOAD_RELATIONALFIELDS_IMPLEMENTINGCUSTOMPOSTLIST:
                return ListQueryInputOutputHandler::class;
        }

        return parent::getQueryInputOutputHandlerClass($module);
    }

    public function getFilterSubmodule(array $module): ?array
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTLIST:
                return [
                    CustomPostFilterInnerModuleProcessor::class,
                    CustomPostFilterInnerModuleProcessor::MODULE_FILTERINNER_CUSTOMPOSTLIST
                ];
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTCOUNT:
                return [
                    CustomPostFilterInnerModuleProcessor::class,
                    CustomPostFilterInnerModuleProcessor::MODULE_FILTERINNER_CUSTOMPOSTCOUNT
                ];
            case self::MODULE_DATALOAD_RELATIONALFIELDS_IMPLEMENTINGCUSTOMPOSTLIST:
                return [
                    CustomPostFilterInnerModuleProcessor::class,
                    CustomPostFilterInnerModuleProcessor::MODULE_FILTERINNER_IMPLEMENTINGCUSTOMPOSTLIST
                ];
            case self::MODULE_DATALOAD_RELATIONALFIELDS_IMPLEMENTINGCUSTOMPOSTCOUNT:
                return [
                    CustomPostFilterInnerModuleProcessor::class,
                    CustomPostFilterInnerModuleProcessor::MODULE_FILTERINNER_IMPLEMENTINGCUSTOMPOSTCOUNT
                ];
        }

        return parent::getFilterSubmodule($module);
    }
}
