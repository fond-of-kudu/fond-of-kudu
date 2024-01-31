<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ProductResourceAliasStorage\ProductResourceAliasStorageClient;

class DiscountPromotionRestApiToProductResourceAliasStorageClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ProductResourceAliasStorage\ProductResourceAliasStorageClient
     */
    protected MockObject|ProductResourceAliasStorageClient $productResourceAliasStorageClientMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
     */
    protected DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productResourceAliasStorageClientMock = $this->getMockBuilder(ProductResourceAliasStorageClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new DiscountPromotionRestApiToProductResourceAliasStorageClientBridge(
            $this->productResourceAliasStorageClientMock,
        );
    }

    /**
     * @return void
     */
    public function testGetBulkProductAbstractStorageData(): void
    {
        $skus = ['sku-0', 'sku-1', 'sku-2'];
        $locale = 'de_DE';

        $this->productResourceAliasStorageClientMock->expects(static::atLeastOnce())
            ->method('getBulkProductAbstractStorageData')
            ->with($skus, $locale);

        $this->bridge->getBulkProductAbstractStorageData($skus, $locale);
    }
}
