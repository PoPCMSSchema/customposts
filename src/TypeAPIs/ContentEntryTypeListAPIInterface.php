<?php

declare(strict_types=1);

namespace PoP\Content\TypeAPIs;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface ContentEntryTypeListAPIInterface
{
    public function getContentEntries($query, array $options = []);
    public function getContentEntryCount(array $query = [], array $options = []): int;
}
