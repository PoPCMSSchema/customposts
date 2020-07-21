<?php

declare(strict_types=1);

namespace PoP\CustomPosts\TypeDataLoaders;

use PoP\CustomPosts\Types\Status;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\LooseContracts\Facades\NameResolverFacade;
use PoP\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoP\ComponentModel\TypeDataLoaders\AbstractTypeQueryableDataLoader;
use PoP\CustomPosts\ModuleProcessors\CustomPostRelationalFieldDataloadModuleProcessor;

abstract class AbstractCustomPostTypeDataLoader extends AbstractTypeQueryableDataLoader
{
    public function getFilterDataloadingModule(): ?array
    {
        return [
            CustomPostRelationalFieldDataloadModuleProcessor::class,
            CustomPostRelationalFieldDataloadModuleProcessor::MODULE_DATALOAD_RELATIONALFIELDS_CUSTOMPOSTLIST
        ];
    }

    public function getObjectQuery(array $ids): array
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        return array(
            'include' => $ids,
            // If not adding the post types, WordPress only uses "post", so querying by CPT would fail loading data
            // This should be considered for the CMS-agnostic case if it makes sense
            'custom-post-types' => $customPostTypeAPI->getCustomPostTypes([
                'publicly-queryable' => true,
            ])
        );
    }

    public function getObjects(array $ids): array
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        $query = $this->getObjectQuery($ids);
        return $customPostTypeAPI->getCustomPosts($query);
    }

    public function getDataFromIdsQuery(array $ids): array
    {
        $query = array();
        $query['include'] = $ids;
        $query['custom-post-status'] = [
            Status::PUBLISHED,
            Status::DRAFT,
            Status::PENDING,
        ]; // Status can also be 'pending', so don't limit it here, just select by ID

        return $query;
    }

    public function executeQuery($query, array $options = [])
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        return $customPostTypeAPI->getCustomPosts($query, $options);
    }

    protected function getOrderbyDefault()
    {
        return NameResolverFacade::getInstance()->getName('popcms:dbcolumn:orderby:customposts:date');
    }

    protected function getOrderDefault()
    {
        return 'DESC';
    }

    public function executeQueryIds($query): array
    {
        $options = [
            'return-type' => \POP_RETURNTYPE_IDS,
        ];
        return (array)$this->executeQuery($query, $options);
    }

    protected function getLimitParam($query_args)
    {
        return HooksAPIFacade::getInstance()->applyFilters(
            'CustomPostTypeDataLoader:query:limit',
            parent::getLimitParam($query_args)
        );
    }

    protected function getQueryHookName()
    {
        // Allow to add the timestamp for loadingLatest
        return 'CustomPostTypeDataLoader:query';
    }
}
