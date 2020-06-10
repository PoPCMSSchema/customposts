<?php

declare(strict_types=1);

namespace PoP\Content;

use PoP\ComponentModel\ComponentConfiguration\EnvironmentValueHelpers;
use PoP\ComponentModel\ComponentConfiguration\ComponentConfigurationTrait;

class ComponentConfiguration
{
    use ComponentConfigurationTrait;

    private static $getContentEntityListDefaultLimit;
    private static $getContentEntityListMaxLimit;

    public static function getContentEntityListDefaultLimit(): ?int
    {
        // Define properties
        $envVariable = Environment::CONTENT_ENTITY_LIST_DEFAULT_LIMIT;
        $selfProperty = &self::$getContentEntityListDefaultLimit;
        $defaultValue = 10;
        $callback = [EnvironmentValueHelpers::class, 'toInt'];

        // Initialize property from the environment/hook
        self::maybeInitializeConfigurationValue(
            $envVariable,
            $selfProperty,
            $defaultValue,
            $callback
        );
        return $selfProperty;
    }

    public static function getContentEntityListMaxLimit(): ?int
    {
        // Define properties
        $envVariable = Environment::CONTENT_ENTITY_LIST_MAX_LIMIT;
        $selfProperty = &self::$getContentEntityListMaxLimit;
        $defaultValue = -1; // Unlimited
        $callback = [EnvironmentValueHelpers::class, 'toInt'];

        // Initialize property from the environment/hook
        self::maybeInitializeConfigurationValue(
            $envVariable,
            $selfProperty,
            $defaultValue,
            $callback
        );
        return $selfProperty;
    }
}
