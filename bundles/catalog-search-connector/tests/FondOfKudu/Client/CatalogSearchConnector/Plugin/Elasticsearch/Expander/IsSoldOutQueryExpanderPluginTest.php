<?php

namespace FondOfKudu\Client\CatalogSearchConnector\Plugin\Elasticsearch\Expander;

use Codeception\Test\Unit;
use Elastica\Query;
use FondOfKudu\Shared\CatalogSearchConnector\CatalogSearchConnectorConstants;
use Generated\Shared\Search\PageIndexMap;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\SearchElasticsearch\Config\SortConfig;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class IsSoldOutQueryExpanderPluginTest extends Unit
{
    /**
     * @var \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QueryInterface|MockObject $queryMock;

    /**
     * @var \Elastica\Query|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Query|MockObject $esQueryMock;

    /**
     * @var \FondOfKudu\Client\CatalogSearchConnector\Plugin\Elasticsearch\Expander\IsSoldOutQueryExpanderPlugin
     */
    protected IsSoldOutQueryExpanderPlugin $isSoldOutQueryExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->queryMock = $this->createMock(QueryInterface::class);
        $this->esQueryMock = $this->createMock(Query::class);
        $this->isSoldOutQueryExpanderPlugin = new IsSoldOutQueryExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $requestParameters = [CatalogSearchConnectorConstants::ATTR_IS_SOLD_OUT => 1];

        $this->queryMock->expects(static::once())
            ->method('getSearchQuery')
            ->willReturn($this->esQueryMock);

        $this->esQueryMock->expects(static::once())
            ->method('addSort')
            ->with([
                PageIndexMap::STRING_SORT . '.' . CatalogSearchConnectorConstants::ATTR_IS_SOLD_OUT => [
                    'order' => SortConfig::DIRECTION_DESC,
                    'mode' => 'min',
                ],
            ]);

        $searchQuery = $this->isSoldOutQueryExpanderPlugin->expandQuery($this->queryMock, $requestParameters);

        static::assertEquals($this->queryMock, $searchQuery);
    }
}
