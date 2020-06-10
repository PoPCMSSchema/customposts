<?php

declare(strict_types=1);

namespace PoP\Content\TypeAPIs;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface ContentEntityTypeListAPIInterface extends ContentEntryTypeListAPIInterface
{
    public function getContentEntities($query, array $options = []);
    public function getContentEntityCount(array $query = [], array $options = []): int;
}
