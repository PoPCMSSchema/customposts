<?php

declare(strict_types=1);

namespace PoP\Content\Facades;

use PoP\Content\TypeAPIs\CustomPostTypeAPIInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class CustomPostTypeAPIFacade
{
    public static function getInstance(): CustomPostTypeAPIInterface
    {
        return ContainerBuilderFactory::getInstance()->get('custom_post_type_api');
    }
}
