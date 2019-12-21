<?php
namespace PoP\Content\TypeDataLoaders;

use PoP\ComponentModel\TypeDataLoaders\AbstractTypeQueryableDataLoader;

class ContentEntityUnionTypeDataLoader extends AbstractTypeQueryableDataLoader
{
    public function getDataquery()
    {
        return null;
    }

    // public function getObjectQuery(array $ids): array
    // {
    //     return array(
    //         'include' => $ids,
    //     );
    // }

    public function getObjects(array $ids): array
    {
        return [];
    }

    // public function getDataFromIdsQuery(array $ids): array
    // {
    //     return [
    //         'include' => $ids,
    //     ];
    // }

    // public function executeQuery($query, array $options = [])
    // {
    //     $contentEntityTypeAPI = ContentEntityTypeAPIFacade::getInstance();
    //     return $contentEntityTypeAPI->getContentEntities($query, $options);
    // }

    // public function executeQueryIds($query): array
    // {
    //     $options = [
    //         'return-type' => POP_RETURNTYPE_IDS,
    //     ];
    //     return (array)$this->executeQuery($query, $options);
    // }
}
