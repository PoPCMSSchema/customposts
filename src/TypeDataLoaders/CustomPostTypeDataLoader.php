<?php

declare(strict_types=1);

namespace PoP\CustomPosts\TypeDataLoaders;

use PoP\CustomPosts\TypeDataLoaders\AbstractCustomPostTypeDataLoader;
use PoP\CustomPosts\ModuleProcessors\CustomPostRelationalFieldDataloadModuleProcessor;

class CustomPostTypeDataLoader extends AbstractCustomPostTypeDataLoader
{
    public function getFilterDataloadingModule(): ?array
    {
        return [
            CustomPostRelationalFieldDataloadModuleProcessor::class,
            CustomPostRelationalFieldDataloadModuleProcessor::MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTLIST
        ];
    }
}
