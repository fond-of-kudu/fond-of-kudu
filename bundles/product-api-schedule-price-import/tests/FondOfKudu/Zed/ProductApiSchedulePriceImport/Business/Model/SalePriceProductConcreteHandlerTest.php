<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepository;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;

class SalePriceProductConcreteHandlerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected MockObject|ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface
     */
    protected MockObject|ProductApiSchedulePriceImportRepository $productApiSchedulePriceImportRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected MockObject|PriceProductScheduleMapper $priceProductScheduleMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected MockObject|ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge $priceProductScheduleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Monolog\Logger
     */
    protected MockObject|Logger $loggerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected MockObject|MoneyValueTransfer $moneyValueTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    protected MockObject|PriceProductScheduleTransfer $priceProductScheduleTransferMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductConcreteHandler
     */
    protected SalePriceProductConcreteHandler $salePriceProductConcreteHandler;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiSchedulePriceImportConfigMock = $this->createMock(ProductApiSchedulePriceImportConfig::class);
        $this->productApiSchedulePriceImportRepositoryMock = $this->createMock(ProductApiSchedulePriceImportRepository::class);
        $this->priceProductScheduleMapperMock = $this->createMock(PriceProductScheduleMapper::class);
        $this->priceProductScheduleFacadeMock = $this->createMock(ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge::class);
        $this->loggerMock = $this->createMock(Logger::class);
        $this->productConcreteTransferMock = $this->createMock(ProductConcreteTransfer::class);
        $this->priceProductTransferMock = $this->createMock(PriceProductTransfer::class);
        $this->moneyValueTransferMock = $this->createMock(MoneyValueTransfer::class);
        $this->priceProductScheduleTransferMock = $this->createMock(PriceProductScheduleTransfer::class);

        $this->salePriceProductConcreteHandler = new SalePriceProductConcreteHandler(
            $this->priceProductScheduleFacadeMock,
            $this->priceProductScheduleMapperMock,
            $this->productApiSchedulePriceImportRepositoryMock,
            $this->apiSchedulePriceImportConfigMock,
            $this->loggerMock,
        );
    }

    /**
     * @return void
     */
    public function testHandleInvalidAttributes(): void
    {
        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => null,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->productConcreteTransferMock->expects(static::never())
            ->method('getPrices');

        $productConcreteTransfer = $this->salePriceProductConcreteHandler->handle($this->productConcreteTransferMock);

        static::assertEquals($productConcreteTransfer, $this->productConcreteTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleCreate(): void
    {
        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 1500,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getPrices')
            ->willReturn([$this->priceProductTransferMock]);

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductConcrete')
            ->willReturn(1);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getFkCurrency')
            ->willReturn(99);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getFkStore')
            ->willReturn(1);

        $this->productApiSchedulePriceImportRepositoryMock->expects(static::atLeastOnce())
            ->method('findPriceProductScheduleByIdProductConcreteAndIdCurrencyAndIdStore')
            ->with(1, 99, 1)
            ->willReturn(null);

        $this->priceProductScheduleMapperMock->expects(static::atLeastOnce())
            ->method('createFromProductConcreteTransfer')
            ->with($this->priceProductTransferMock, $this->productConcreteTransferMock)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $productConcreteTransfer = $this->salePriceProductConcreteHandler->handle($this->productConcreteTransferMock);

        static::assertEquals($productConcreteTransfer, $this->productConcreteTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleUpdate(): void
    {
        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 1500,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getPrices')
            ->willReturn([$this->priceProductTransferMock]);

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductConcrete')
            ->willReturn(1);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getFkCurrency')
            ->willReturn(99);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getFkStore')
            ->willReturn(1);

        $this->productApiSchedulePriceImportRepositoryMock->expects(static::atLeastOnce())
            ->method('findPriceProductScheduleByIdProductConcreteAndIdCurrencyAndIdStore')
            ->with(1, 99, 1)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('setActiveFrom')
            ->with('2024-01-01')
            ->willReturnSelf();

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('setActiveTo')
            ->with('2024-12-31')
            ->willReturnSelf();

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getPriceProduct')
            ->willReturn($this->priceProductTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('setGrossAmount')
            ->with(1500)
            ->willReturnSelf();

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('updateAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $productConcreteTransfer = $this->salePriceProductConcreteHandler->handle($this->productConcreteTransferMock);

        static::assertEquals($productConcreteTransfer, $this->productConcreteTransferMock);
    }
}
