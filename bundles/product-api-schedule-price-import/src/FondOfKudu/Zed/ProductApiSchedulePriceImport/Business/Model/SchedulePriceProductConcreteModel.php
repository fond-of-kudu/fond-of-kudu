<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class SchedulePriceProductConcreteModel implements SchedulePriceProductConcreteModelInterface
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
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    public function create(ProductConcreteTransfer $productConcreteTransfer): void
    {
        $priceProductScheduleTransfer = $this->priceProductScheduleMapper
            ->createFromProductConcreteTransfer($productConcreteTransfer);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return void
     */
    public function update(
        ProductConcreteTransfer $productConcreteTransfer,
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): void {
        $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
            $priceProductScheduleTransfer->getIdPriceProductSchedule(),
        );

        $priceProductScheduleTransfer = $this->priceProductScheduleMapper
            ->createFromProductConcreteTransfer($productConcreteTransfer);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }
}
