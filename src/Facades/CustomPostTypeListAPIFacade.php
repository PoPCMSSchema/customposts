<?php

declare(strict_types=1);

namespace PoP\Content\Facades;

use PoP\Content\TypeAPIs\CustomPostTypeListAPIInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class CustomPostTypeListAPIFacade
{
    public static function getInstance(): CustomPostTypeListAPIInterface
    {
        return ContainerBuilderFactory::getInstance()->get('content_entity_type_list_api');
    }
}
