<?php

declare(strict_types=1);

namespace PoP\CustomPosts\Facades;

use PoP\CustomPosts\TypeAPIs\CustomPostTypeListAPIInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class CustomPostTypeListAPIFacade
{
    public static function getInstance(): CustomPostTypeListAPIInterface
    {
        return ContainerBuilderFactory::getInstance()->get('custom_post_type_list_api');
    }
}
