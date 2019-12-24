<?php
namespace PoP\Content\TypeAPIs;

use PoP\Content\TypeAPIs\ContentEntryTypeAPIInterface;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface ContentEntityTypeAPIInterface extends ContentEntryTypeAPIInterface
{
    public function getTitle($id): ?string;
    public function getExcerpt($objectOrID): ?string;
}
