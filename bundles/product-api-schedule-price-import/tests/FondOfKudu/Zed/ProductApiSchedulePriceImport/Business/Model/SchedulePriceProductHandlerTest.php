<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidator;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepository;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SchedulePriceProductHandlerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToCurrencyFacadeBridge $currencyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToStoreFacadeBridge $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepository
     */
    protected MockObject|ProductApiSchedulePriceImportRepository $productApiSchedulePriceImportRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected MockObject|ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected MockObject|StoreTransfer $storeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    protected MockObject|PriceProductScheduleTransfer $priceProductScheduleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected MockObject|MoneyValueTransfer $moneyValueTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidator
     */
    protected MockObject|SpecialPriceAttributesValidator $specialPriceAttributesValidator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModel
     */
    protected MockObject|SchedulePriceProductAbstractModel $schedulePriceProductAbstractModelMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModel
     */
    protected MockObject|SchedulePriceProductConcreteModel $schedulePriceProductConcreteModelMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductHandlerInterface
     */
    protected SchedulePriceProductHandlerInterface $salePriceHandler;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->currencyFacadeMock = $this->createMock(ProductApiSchedulePriceImportToCurrencyFacadeBridge::class);
        $this->storeFacadeMock = $this->createMock(ProductApiSchedulePriceImportToStoreFacadeBridge::class);
        $this->productApiSchedulePriceImportRepositoryMock = $this->createMock(ProductApiSchedulePriceImportRepository::class);
        $this->apiSchedulePriceImportConfigMock = $this->createMock(ProductApiSchedulePriceImportConfig::class);
        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->productConcreteTransferMock = $this->createMock(ProductConcreteTransfer::class);
        $this->currencyTransferMock = $this->createMock(CurrencyTransfer::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);
        $this->priceProductScheduleTransferMock = $this->createMock(PriceProductScheduleTransfer::class);
        $this->priceProductTransferMock = $this->createMock(PriceProductTransfer::class);
        $this->moneyValueTransferMock = $this->createMock(MoneyValueTransfer::class);
        $this->specialPriceAttributesValidator = $this->createMock(SpecialPriceAttributesValidator::class);
        $this->schedulePriceProductAbstractModelMock = $this->createMock(SchedulePriceProductAbstractModel::class);
        $this->schedulePriceProductConcreteModelMock = $this->createMock(SchedulePriceProductConcreteModel::class);

        $this->salePriceHandler = new SchedulePriceProductHandler(
            $this->schedulePriceProductAbstractModelMock,
            $this->schedulePriceProductConcreteModelMock,
            $this->specialPriceAttributesValidator,
            $this->apiSchedulePriceImportConfigMock,
        );
    }

    /**
     * @return void
     */
    public function testHandleProductAbstractInvalidAttributes(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => null,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->specialPriceAttributesValidator->expects(static::atLeastOnce())
            ->method('validate')
            ->with([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => null,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ])
            ->willReturn(false);

        $this->currencyFacadeMock->expects(static::never())
            ->method('getCurrent');

        $productAbstractTransfer = $this->salePriceHandler->handleProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleProductAbstractCreateNew(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->specialPriceAttributesValidator->expects(static::atLeastOnce())
            ->method('validate')
            ->with([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ])
            ->willReturn(true);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->schedulePriceProductAbstractModelMock->expects(static::atLeastOnce())
            ->method('getPriceProductScheduleTransfer')
            ->with(1)
            ->willReturn(null);

        $this->schedulePriceProductAbstractModelMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->productAbstractTransferMock);

        $productAbstractTransfer = $this->salePriceHandler->handleProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleProductAbstractUpdate(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->specialPriceAttributesValidator->expects(static::atLeastOnce())
            ->method('validate')
            ->with([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ])
            ->willReturn(true);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);
        $this->schedulePriceProductAbstractModelMock->expects(static::atLeastOnce())
            ->method('getPriceProductScheduleTransfer')
            ->with(1)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveFrom')
            ->willReturn('2024-03-01');

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveTo')
            ->willReturn('2025-01-01');

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getPriceProduct')
            ->willReturn($this->priceProductTransferMock);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn(2599);

        $this->schedulePriceProductAbstractModelMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->productAbstractTransferMock, $this->priceProductScheduleTransferMock);

        $productAbstractTransfer = $this->salePriceHandler->handleProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleProductConcreteInvalidAttributes(): void
    {
        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => null,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->specialPriceAttributesValidator->expects(static::atLeastOnce())
            ->method('validate')
            ->with([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => null,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ])
            ->willReturn(false);

        $this->currencyFacadeMock->expects(static::never())
            ->method('getCurrent');

        $productConcreteTransfer = $this->salePriceHandler->handleProductConcrete($this->productConcreteTransferMock);

        static::assertEquals($productConcreteTransfer, $this->productConcreteTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleProductConcreteCreateNew(): void
    {
        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->specialPriceAttributesValidator->expects(static::atLeastOnce())
            ->method('validate')
            ->with([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ])
            ->willReturn(true);

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductConcrete')
            ->willReturn(1);

        $this->schedulePriceProductConcreteModelMock->expects(static::atLeastOnce())
            ->method('getPriceProductScheduleTransfer')
            ->with(1)
            ->willReturn(null);

        $this->schedulePriceProductConcreteModelMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->productConcreteTransferMock);

        $productConcreteTransfer = $this->salePriceHandler->handleProductConcrete($this->productConcreteTransferMock);

        static::assertEquals($productConcreteTransfer, $this->productConcreteTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleProductConcreteUpdate(): void
    {
        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->specialPriceAttributesValidator->expects(static::atLeastOnce())
            ->method('validate')
            ->with([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ])
            ->willReturn(true);

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
            ->method('getIdProductConcrete')
            ->willReturn(1);

        $this->schedulePriceProductConcreteModelMock->expects(static::atLeastOnce())
            ->method('getPriceProductScheduleTransfer')
            ->with(1)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveFrom')
            ->willReturn('2024-03-01');

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveTo')
            ->willReturn('2025-01-01');

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getPriceProduct')
            ->willReturn($this->priceProductTransferMock);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn(2599);

        $this->schedulePriceProductConcreteModelMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->productConcreteTransferMock, $this->priceProductScheduleTransferMock);

        $productConcreteTransfer = $this->salePriceHandler->handleProductConcrete($this->productConcreteTransferMock);

        static::assertEquals($productConcreteTransfer, $this->productConcreteTransferMock);
    }
}
