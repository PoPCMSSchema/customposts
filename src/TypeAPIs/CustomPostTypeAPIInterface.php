<?php

declare(strict_types=1);

namespace PoP\CustomPosts\TypeAPIs;

use PoP\CustomPosts\Types\CustomPostTypeInterface;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface CustomPostTypeAPIInterface extends CustomPostTypeInterface
{
    /**
     * Get the custom post with provided ID or, if it doesn't exist, null
     *
     * @param [type] $id
     * @return void
     */
    public function getCustomPost($id): ?object;
    public function getCustomPostType($objectOrID): string;
    public function getCustomPosts($query, array $options = []);
    public function getCustomPostCount(array $query = [], array $options = []): int;
    public function getCustomPostTypes(array $query = array()): array;
}
