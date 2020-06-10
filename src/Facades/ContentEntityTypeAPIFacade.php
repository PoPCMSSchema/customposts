<?php

declare(strict_types=1);

namespace PoP\Content\Facades;

use PoP\Content\TypeAPIs\ContentEntityTypeAPIInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class ContentEntityTypeAPIFacade
{
    public static function getInstance(): ContentEntityTypeAPIInterface
    {
        return ContainerBuilderFactory::getInstance()->get('content_entity_type_api');
    }
}
