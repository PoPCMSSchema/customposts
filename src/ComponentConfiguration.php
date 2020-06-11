<?php

declare(strict_types=1);

namespace PoP\CustomPosts;

use PoP\ComponentModel\ComponentConfiguration\EnvironmentValueHelpers;
use PoP\ComponentModel\ComponentConfiguration\ComponentConfigurationTrait;

class ComponentConfiguration
{
    use ComponentConfigurationTrait;

    private static $getCustomPostListDefaultLimit;
    private static $getCustomPostListMaxLimit;

    public static function getCustomPostListDefaultLimit(): ?int
    {
        // Define properties
        $envVariable = Environment::CUSTOM_POST_LIST_DEFAULT_LIMIT;
        $selfProperty = &self::$getCustomPostListDefaultLimit;
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

    public static function getCustomPostListMaxLimit(): ?int
    {
        // Define properties
        $envVariable = Environment::CUSTOM_POST_LIST_MAX_LIMIT;
        $selfProperty = &self::$getCustomPostListMaxLimit;
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
