<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SchedulePriceProductConcreteModelTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    protected MockObject|PriceProductScheduleTransfer $priceProductScheduleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper
     */
    protected MockObject|PriceProductScheduleMapper $priceProductScheduleMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge $priceProductScheduleFacadeMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModel
     */
    protected SchedulePriceProductConcreteModel $schedulePriceProductConcreteModel;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productConcreteTransferMock = $this->createMock(ProductConcreteTransfer::class);
        $this->priceProductScheduleTransferMock = $this->createMock(PriceProductScheduleTransfer::class);
        $this->priceProductScheduleMapperMock = $this->createMock(PriceProductScheduleMapper::class);
        $this->priceProductScheduleFacadeMock = $this->createMock(ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge::class);

        $this->schedulePriceProductConcreteModel = new SchedulePriceProductConcreteModel(
            $this->priceProductScheduleMapperMock,
            $this->priceProductScheduleFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->priceProductScheduleMapperMock->expects(static::atLeastOnce())
            ->method('createFromProductConcreteTransfer')
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $this->schedulePriceProductConcreteModel->create($this->productConcreteTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceProductSchedule')
            ->willReturn(1);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('removeAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock->getIdPriceProductSchedule());

        $this->priceProductScheduleMapperMock->expects(static::atLeastOnce())
            ->method('createFromProductConcreteTransfer')
            ->with($this->productConcreteTransferMock)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $this->schedulePriceProductConcreteModel->update(
            $this->productConcreteTransferMock,
            $this->priceProductScheduleTransferMock,
        );
    }
}
