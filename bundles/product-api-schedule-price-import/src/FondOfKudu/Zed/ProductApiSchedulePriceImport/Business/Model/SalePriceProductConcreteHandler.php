<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class SalePriceProductConcreteHandler implements SalePriceProductConcreteHandlerInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface
     */
    protected ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected PriceProductScheduleMapperInterface $priceProductScheduleMapper;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface $priceProductScheduleMapper
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(
        ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade,
        PriceProductScheduleMapperInterface $priceProductScheduleMapper,
        ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
    ) {
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
        $this->productApiSchedulePriceImportRepository = $productApiSchedulePriceImportRepository;
        $this->priceProductScheduleMapper = $priceProductScheduleMapper;
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param array $attributes
     *
     * @return void
     */
    public function handle(
        ProductConcreteTransfer $productConcreteTransfer,
        array $attributes = []
    ): void {
        foreach ($productConcreteTransfer->getPrices() as $priceProductTransfer) {
            $priceProductScheduleTransfer = $this->productApiSchedulePriceImportRepository
                ->findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore(
                    $productConcreteTransfer->getIdProductConcrete(),
                    $priceProductTransfer->getMoneyValue()->getFkCurrency(),
                    $priceProductTransfer->getMoneyValue()->getFkStore(),
                );

            if ($priceProductScheduleTransfer === null) {
                $this->create($priceProductTransfer, $attributes);
            } else {
                $this->update($productConcreteTransfer, $priceProductScheduleTransfer);
            }
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param array $attributes
     *
     * @return void
     */
    protected function create(PriceProductTransfer $priceProductTransfer, array $attributes): void
    {
        $priceProductScheduleTransfer = $this->priceProductScheduleMapper->createFromProductConcreteTransfer(
            $priceProductTransfer,
            $attributes,
        );

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return void
     */
    protected function update(
        ProductConcreteTransfer $productConcreteTransfer,
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): void {
        $productAttributes = $productConcreteTransfer->getAttributes();
        $specialPriceFrom = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];

        $priceProductScheduleTransfer
            ->setActiveFrom($specialPriceFrom)
            ->setActiveTo($specialPriceTo)
            ->getPriceProduct()->getMoneyValue()->setGrossAmount($specialPrice);

        $this->priceProductScheduleFacade->updateAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }
}
