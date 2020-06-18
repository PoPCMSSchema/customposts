<?php

declare(strict_types=1);

namespace PoP\CustomPosts\ModuleProcessors;

use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\ModuleProcessors\AbstractModuleProcessor;

class CustomPostFilterInnerModuleProcessor extends AbstractModuleProcessor
{
    public const MODULE_FILTERINNER_CUSTOMPOSTLIST = 'filterinner-custompostlist';
    public const MODULE_FILTERINNER_CUSTOMPOSTCOUNT = 'filterinner-custompostcount';
    public const MODULE_FILTERINNER_IMPLEMENTINGCUSTOMPOSTLIST = 'filterinner-implementingcustompostlist';
    public const MODULE_FILTERINNER_IMPLEMENTINGCUSTOMPOSTCOUNT = 'filterinner-implementingcustompostcount';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FILTERINNER_CUSTOMPOSTLIST],
            [self::class, self::MODULE_FILTERINNER_CUSTOMPOSTCOUNT],
            [self::class, self::MODULE_FILTERINNER_IMPLEMENTINGCUSTOMPOSTLIST],
            [self::class, self::MODULE_FILTERINNER_IMPLEMENTINGCUSTOMPOSTCOUNT],
        );
    }

    public function getSubmodules(array $module): array
    {
        $ret = parent::getSubmodules($module);

        switch ($module[1]) {
            case self::MODULE_FILTERINNER_CUSTOMPOSTLIST:
            case self::MODULE_FILTERINNER_IMPLEMENTINGCUSTOMPOSTLIST:
                $inputmodules = [
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_SEARCH],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_ORDER],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_LIMIT],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_OFFSET],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_DATES],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_IDS],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_ID],
                ];
                break;
            case self::MODULE_FILTERINNER_CUSTOMPOSTCOUNT:
            case self::MODULE_FILTERINNER_IMPLEMENTINGCUSTOMPOSTCOUNT:
                $inputmodules = [
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_SEARCH],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_DATES],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_IDS],
                    [\PoP_Module_Processor_FilterInputs::class, \PoP_Module_Processor_FilterInputs::MODULE_FILTERINPUT_ID],
                ];
                break;
        }
        // Fields "customPosts" and "customPostCount" also have the "postTypes" filter
        if (in_array($module[1], [
            self::MODULE_FILTERINNER_CUSTOMPOSTLIST,
            self::MODULE_FILTERINNER_CUSTOMPOSTCOUNT,
        ])) {
            $inputmodules[] = [
                \PoP_CustomPosts_Module_Processor_FilterInputs::class,
                \PoP_CustomPosts_Module_Processor_FilterInputs::MODULE_FILTERINPUT_UNIONCUSTOMPOSTTYPES
            ];
        }
        if ($modules = HooksAPIFacade::getInstance()->applyFilters(
            'CustomPosts:FilterInners:inputmodules',
            $inputmodules,
            $module
        )) {
            $ret = array_merge(
                $ret,
                $modules
            );
        }
        return $ret;
    }
}
