<?php

declare(strict_types=1);

namespace PoP\Content\Facades;

use PoP\Content\TypeAPIs\ContentEntityTypeListAPIInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class ContentEntityTypeListAPIFacade
{
    public static function getInstance(): ContentEntityTypeListAPIInterface
    {
        return ContainerBuilderFactory::getInstance()->get('content_entity_type_list_api');
    }
}
