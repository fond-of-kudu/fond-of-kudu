<?php

namespace FondOfKudu\Client\CatalogSearchConnector\Plugin\Elasticsearch\Expander;

use Elastica\Query;
use FondOfKudu\Shared\CatalogSearchConnector\CatalogSearchConnectorConstants;
use Generated\Shared\Search\PageIndexMap;
use Spryker\Client\SearchElasticsearch\Config\SortConfig;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class AvailableQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<string, mixed> $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        if (!isset($requestParameters[CatalogSearchConnectorConstants::ATTR_AVAILABLE])) {
            return $searchQuery;
        }

        $this->addSort($searchQuery->getSearchQuery());

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $searchQuery
     *
     * @return void
     */
    protected function addSort(Query $searchQuery): void
    {
        $searchQuery->addSort([
            PageIndexMap::INTEGER_SORT . '.' . CatalogSearchConnectorConstants::ATTR_AVAILABLE => [
                'order' => SortConfig::DIRECTION_ASC,
                'mode' => 'min',
            ],
        ]);
    }
}
