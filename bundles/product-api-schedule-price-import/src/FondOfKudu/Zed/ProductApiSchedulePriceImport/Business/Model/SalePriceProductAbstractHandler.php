<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class SalePriceProductAbstractHandler implements SalePriceProductAbstractHandlerInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected PriceProductScheduleMapperInterface $priceProductScheduleMapper;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface
     */
    protected ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository;

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
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
        $this->priceProductScheduleMapper = $priceProductScheduleMapper;
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
        $this->productApiSchedulePriceImportRepository = $productApiSchedulePriceImportRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handle(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        if (!$this->validateSpecialPriceAttributes($productAbstractTransfer)) {
            return $productAbstractTransfer;
        }

        foreach ($productAbstractTransfer->getPrices() as $priceProductTransfer) {
            $priceProductScheduleTransfer = $this->productApiSchedulePriceImportRepository
                ->findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore(
                    $productAbstractTransfer->getIdProductAbstract(),
                    $priceProductTransfer->getMoneyValue()->getFkCurrency(),
                    $priceProductTransfer->getMoneyValue()->getFkStore(),
                );

            if ($priceProductScheduleTransfer === null) {
                $this->create($productAbstractTransfer, $priceProductTransfer);
            } else {
                $this->update($productAbstractTransfer, $priceProductScheduleTransfer);
            }
        }

        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return void
     */
    protected function create(
        ProductAbstractTransfer $productAbstractTransfer,
        PriceProductTransfer $priceProductTransfer
    ): void {
        $priceProductScheduleTransfer = $this->priceProductScheduleMapper->createFromProductAbstractTransfer(
            $productAbstractTransfer,
            $priceProductTransfer,
        );

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return void
     */
    protected function update(
        ProductAbstractTransfer $productAbstractTransfer,
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): void {
        $productAttributes = $productAbstractTransfer->getAttributes();
        $specialPriceFrom = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];

        $priceProductScheduleTransfer
            ->setActiveFrom($specialPriceFrom)
            ->setActiveTo($specialPriceTo)
            ->getPriceProduct()->getMoneyValue()->setGrossAmount($specialPrice);

        $this->priceProductScheduleFacade->updateAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return bool
     */
    protected function validateSpecialPriceAttributes(ProductAbstractTransfer $productAbstractTransfer): bool
    {
        $required = [
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePrice(),
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom(),
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $attribute) {
            if (!isset($productAbstractTransfer->getAttributes()[$attribute])) {
                return false;
            }

            if (!$productAbstractTransfer->getAttributes()[$attribute]) {
                return false;
            }
        }

        return true;
    }
}
