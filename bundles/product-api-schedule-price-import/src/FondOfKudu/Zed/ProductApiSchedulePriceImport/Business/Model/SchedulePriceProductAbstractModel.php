<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class SchedulePriceProductAbstractModel implements SchedulePriceProductAbstractModelInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected PriceProductScheduleMapperInterface $priceProductScheduleMapper;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface $priceProductScheduleMapper
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
     */
    public function __construct(
        PriceProductScheduleMapperInterface $priceProductScheduleMapper,
        ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
    ) {
        $this->priceProductScheduleMapper = $priceProductScheduleMapper;
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return void
     */
    public function create(ProductAbstractTransfer $productAbstractTransfer): void
    {
        $priceProductScheduleTransfer = $this->priceProductScheduleMapper
            ->createFromProductAbstractTransfer($productAbstractTransfer);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return void
     */
    public function update(
        ProductAbstractTransfer $productAbstractTransfer,
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): void {
        $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
            $priceProductScheduleTransfer->getIdPriceProductSchedule(),
        );

        $priceProductScheduleTransfer = $this->priceProductScheduleMapper
            ->createFromProductAbstractTransfer($productAbstractTransfer);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }
}
