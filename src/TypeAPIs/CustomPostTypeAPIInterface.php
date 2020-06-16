<?php

declare(strict_types=1);

namespace PoP\CustomPosts\TypeAPIs;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
interface CustomPostTypeAPIInterface
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
    public function getTitle($id): ?string;
    public function getExcerpt($objectOrID): ?string;
    public function getCustomPostType($objectOrID): string;
}
