<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SchedulePriceProductAbstractModelTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

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
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface
     */
    protected SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->priceProductScheduleTransferMock = $this->createMock(PriceProductScheduleTransfer::class);
        $this->priceProductScheduleMapperMock = $this->createMock(PriceProductScheduleMapper::class);
        $this->priceProductScheduleFacadeMock = $this->createMock(ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge::class);

        $this->schedulePriceProductAbstractModel = new SchedulePriceProductAbstractModel(
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
            ->method('createFromProductAbstractTransfer')
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $this->schedulePriceProductAbstractModel->create($this->productAbstractTransferMock);
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
            ->method('createFromProductAbstractTransfer')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $this->schedulePriceProductAbstractModel->update(
            $this->productAbstractTransferMock,
            $this->priceProductScheduleTransferMock,
        );
    }
}
