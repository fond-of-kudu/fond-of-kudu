<?php

namespace FondOfKudu\Client\ProductPageSearchConnector\Plugin\Elasticsearch\Expander;

use Elastica\Query;
use FondOfKudu\Shared\ProductPageSearchConnector\ProductPageSearchConnectorConstants;
use Generated\Shared\Search\PageIndexMap;
use Spryker\Client\SearchElasticsearch\Config\SortConfig;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class IsSoldOutQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<string, mixed> $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        if (!isset($requestParameters[ProductPageSearchConnectorConstants::ATTR_IS_SOLD_OUT])) {
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
            PageIndexMap::STRING_SORT . '.' . ProductPageSearchConnectorConstants::ATTR_IS_SOLD_OUT => [
                'order' => SortConfig::DIRECTION_DESC,
                'mode' => 'min',
            ],
        ]);
    }
}