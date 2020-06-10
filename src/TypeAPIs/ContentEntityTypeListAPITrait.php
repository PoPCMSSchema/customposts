<?php

declare(strict_types=1);

namespace PoP\Content\TypeAPIs;

trait ContentEntityTypeListAPITrait
{
    public function getContentEntries($query, array $options = [])
    {
        return $this->getContentEntities($query, $options);
    }
    public function getContentEntryCount(array $query = [], array $options = []): int
    {
        return $this->getContentEntityCount($query, $options);
    }
}
