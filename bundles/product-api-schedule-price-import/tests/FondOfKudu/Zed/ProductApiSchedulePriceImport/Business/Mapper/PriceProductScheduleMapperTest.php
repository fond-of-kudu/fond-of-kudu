<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\PriceTypeTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductScheduleMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected MockObject|ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToPriceProductFacadeBridge $priceProductFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected MockObject|MoneyValueTransfer $moneyValueTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceTypeTransfer
     */
    protected MockObject|PriceTypeTransfer $priceTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected MockObject|StoreTransfer $storeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper
     */
    protected PriceProductScheduleMapper $priceProductScheduleMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiSchedulePriceImportConfigMock = $this->createMock(ProductApiSchedulePriceImportConfig::class);
        $this->priceProductFacadeMock = $this->createMock(ProductApiSchedulePriceImportToPriceProductFacadeBridge::class);
        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->priceProductTransferMock = $this->createMock(PriceProductTransfer::class);
        $this->moneyValueTransferMock = $this->createMock(MoneyValueTransfer::class);
        $this->priceTypeTransferMock = $this->createMock(PriceTypeTransfer::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);
        $this->currencyTransferMock = $this->createMock(CurrencyTransfer::class);
        $this->productConcreteTransferMock = $this->createMock(ProductConcreteTransfer::class);

        $this->priceProductScheduleMapper = new PriceProductScheduleMapper(
            $this->priceProductFacadeMock,
            $this->apiSchedulePriceImportConfigMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateFromProductAbstractTransfer(): void
    {
        $this->productAbstractTransferMock->expects(static::once())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 1000,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::once())
            ->method('setGrossAmount')
            ->with(1000)
            ->willReturnSelf();

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getIdPriceProductScheduleList')
            ->willReturn(1);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getPriceDimensionRrp')
            ->willReturn(ProductApiSchedulePriceImportConstants::PRICE_DEFAULT);

        $this->priceProductFacadeMock->expects(static::once())
            ->method('findPriceTypeByName')
            ->with(ProductApiSchedulePriceImportConstants::PRICE_DEFAULT)
            ->willReturn($this->priceTypeTransferMock);

        $this->moneyValueTransferMock->expects(static::once())
            ->method('getStore')
            ->willReturn($this->storeTransferMock);

        $this->priceProductTransferMock->expects(static::once())
            ->method('setPriceType')
            ->with($this->priceTypeTransferMock)
            ->willReturnSelf();

        $this->moneyValueTransferMock->expects(static::once())
            ->method('getCurrency')
            ->willReturn($this->currencyTransferMock);

        $this->priceProductScheduleMapper->createFromProductAbstractTransfer(
            $this->productAbstractTransferMock,
            $this->priceProductTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateFromProductConcreteTransfer(): void
    {
        $this->productConcreteTransferMock->expects(static::once())
            ->method('getIdProductConcrete')
            ->willReturn(99);

        $this->priceProductTransferMock->expects(static::once())
            ->method('setIdProduct')
            ->with(99)
            ->willReturnSelf();

        $this->productConcreteTransferMock->expects(static::once())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 1000,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::once())
            ->method('setGrossAmount')
            ->with(1000)
            ->willReturnSelf();

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getIdPriceProductScheduleList')
            ->willReturn(1);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getPriceDimensionRrp')
            ->willReturn(ProductApiSchedulePriceImportConstants::PRICE_DEFAULT);

        $this->priceProductFacadeMock->expects(static::once())
            ->method('findPriceTypeByName')
            ->with(ProductApiSchedulePriceImportConstants::PRICE_DEFAULT)
            ->willReturn($this->priceTypeTransferMock);

        $this->moneyValueTransferMock->expects(static::once())
            ->method('getStore')
            ->willReturn($this->storeTransferMock);

        $this->priceProductTransferMock->expects(static::once())
            ->method('setPriceType')
            ->with($this->priceTypeTransferMock)
            ->willReturnSelf();

        $this->moneyValueTransferMock->expects(static::once())
            ->method('getCurrency')
            ->willReturn($this->currencyTransferMock);

        $this->priceProductScheduleMapper->createFromProductConcreteTransfer(
            $this->priceProductTransferMock,
            $this->productConcreteTransferMock,
        );
    }
}
