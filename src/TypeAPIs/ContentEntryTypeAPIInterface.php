<?php
namespace PoP\Content\TypeAPIs;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface ContentEntryTypeAPIInterface
{
    /**
     * Return the object's ID
     *
     * @param [type] $object
     * @return void
     */
    public function getID($object);
    public function getContent($id): ?string;
    public function getPermalink($objectOrID): ?string;
    public function getStatus($objectOrID): ?string;
    public function getPublishedDate($objectOrID): ?string;
    public function getModifiedDate($objectOrID): ?string;
    // public function getAuthorID($objectOrID);
}
