<?php

declare(strict_types=1);

namespace PoP\CustomPosts\Facades;

use PoP\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class CustomPostTypeAPIFacade
{
    public static function getInstance(): CustomPostTypeAPIInterface
    {
        return ContainerBuilderFactory::getInstance()->get('custompost_type_api');
    }
}
