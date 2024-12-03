<?php

namespace FondOfKudu\Zed\CatalogSearchConnector\Communication\Plugin\ProductAbstractMapExpander;

use Codeception\Test\Unit;
use FondOfKudu\Shared\CatalogSearchConnector\CatalogSearchConnectorConstants;
use FondOfKudu\Zed\CatalogSearchConnector\Communication\CatalogSearchConnectorCommunicationFactory;
use FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToAvailabilityFacadeBridge;
use FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToStoreFacadeBridge;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\DecimalObject\Decimal;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilder;

class AvailableMapExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PageMapTransfer
     */
    protected PageMapTransfer|MockObject $pageMapTransferMock;

    /**
     * @var \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected PageMapBuilder|MockObject $pageMapBuilderMock;

    /**
     * @var \Generated\Shared\Transfer\LocaleTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected LocaleTransfer|MockObject $localeTransferMock;

    /**
     * @var \FondOfKudu\Zed\CatalogSearchConnector\Communication\CatalogSearchConnectorCommunicationFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CatalogSearchConnectorCommunicationFactory|MockObject $catalogSearchConnectorCommunicationFactoryMock;

    /**
     * @var \FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToStoreFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CatalogSearchConnectorToStoreFacadeBridge|MockObject $storeFacadeMock;

    /**
     * @var \FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToAvailabilityFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CatalogSearchConnectorToAvailabilityFacadeBridge|MockObject $availabilityFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StoreTransfer|MockObject $storeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductAbstractAvailabilityTransfer|MockObject $productAbstractAvailabilityTransferMock;

    /**
     * @var \Spryker\DecimalObject\Decimal|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Decimal|MockObject $decimalMock;

    /**
     * @var \FondOfKudu\Zed\CatalogSearchConnector\Communication\Plugin\ProductAbstractMapExpander\AvailableMapExpanderPlugin
     */
    protected AvailableMapExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->pageMapTransferMock = $this->createMock(PageMapTransfer::class);
        $this->pageMapBuilderMock = $this->createMock(PageMapBuilder::class);
        $this->localeTransferMock = $this->createMock(LocaleTransfer::class);
        $this->catalogSearchConnectorCommunicationFactoryMock = $this->createMock(CatalogSearchConnectorCommunicationFactory::class);
        $this->storeFacadeMock = $this->createMock(CatalogSearchConnectorToStoreFacadeBridge::class);
        $this->availabilityFacadeMock = $this->createMock(CatalogSearchConnectorToAvailabilityFacadeBridge::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);
        $this->productAbstractAvailabilityTransferMock = $this->createMock(ProductAbstractAvailabilityTransfer::class);
        $this->decimalMock = $this->createMock(Decimal::class);

        $this->plugin = new AvailableMapExpanderPlugin();
        $this->plugin->setFactory($this->catalogSearchConnectorCommunicationFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandProductMap(): void
    {
        $productData = [
            CatalogSearchConnectorConstants::PRODUCT_DATA_LOCALE => 'de_DE',
            CatalogSearchConnectorConstants::PRODUCT_DATA_ID_PRODUCT_ABSTRACT => 99,
            CatalogSearchConnectorConstants::PRODUCT_DATA_SKU => 'SKU-000-1111',
            CatalogSearchConnectorConstants::PRODUCT_DATA_STORE => 'AFFENZAHN_COM',
        ];

        $this->catalogSearchConnectorCommunicationFactoryMock->expects(static::once())
            ->method('getStoreFacade')
            ->willReturn($this->storeFacadeMock);

        $this->storeFacadeMock->expects(static::once())
            ->method('findStoreByName')
            ->with($productData[CatalogSearchConnectorConstants::PRODUCT_DATA_STORE])
            ->willReturn($this->storeTransferMock);

        $this->catalogSearchConnectorCommunicationFactoryMock->expects(static::once())
            ->method('getAvailabilityFacade')
            ->willReturn($this->availabilityFacadeMock);

        $this->availabilityFacadeMock->expects(static::once())
            ->method('findOrCreateProductAbstractAvailabilityBySkuForStore')
            ->with(
                $productData[CatalogSearchConnectorConstants::PRODUCT_DATA_SKU],
                $this->storeTransferMock,
            )
            ->willReturn($this->productAbstractAvailabilityTransferMock);

        $this->productAbstractAvailabilityTransferMock->expects(static::once())
            ->method('getIsNeverOutOfStock')
            ->willReturn(false);

        $this->productAbstractAvailabilityTransferMock->expects(static::once())
            ->method('getAvailability')
            ->willReturn($this->decimalMock);

        $this->decimalMock->expects(static::once())
            ->method('greaterThan')
            ->with(0)
            ->willReturn(true);

        $this->pageMapTransferMock->expects(static::once())
            ->method('setAvailable')
            ->with(true)
            ->willReturnSelf();

        $this->pageMapBuilderMock->expects(static::once())
            ->method('addSearchResultData')
            ->with($this->pageMapTransferMock, CatalogSearchConnectorConstants::ATTR_AVAILABLE, true)
            ->willReturnSelf();

        $pageMapTransfer = $this->plugin->expandProductMap(
            $this->pageMapTransferMock,
            $this->pageMapBuilderMock,
            $productData,
            $this->localeTransferMock,
        );

        static::assertEquals($pageMapTransfer, $this->pageMapTransferMock);
    }
}
