<?php

declare(strict_types=1);

namespace PoP\CustomPosts\TypeAPIs;

use PoP\CustomPosts\Types\CustomPostTypeInterface;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface CustomPostTypeAPIInterface extends CustomPostTypeInterface
{
    public function getCustomPostType($objectOrID): string;
    public function getCustomPosts($query, array $options = []);
    public function getCustomPostCount(array $query = [], array $options = []): int;
}
