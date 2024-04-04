<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
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
    public function onCreateProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        if (!$this->validateSpecialPriceAttributes($productAbstractTransfer)) {
            return $productAbstractTransfer;
        }

        $priceProductScheduleTransfers = $this->priceProductScheduleMapper
            ->fromProductAbstractTransfer($productAbstractTransfer);

        foreach ($priceProductScheduleTransfers as $priceProductScheduleTransfer) {
            $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
        }

        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function onUpdateProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        if (!$this->validateSpecialPriceAttributes($productAbstractTransfer)) {
            return $productAbstractTransfer;
        }

        $priceProductScheduleTransfers = $this->productApiSchedulePriceImportRepository
            ->findLatestPriceProductScheduleByIdProductAbstract($productAbstractTransfer->getIdProductAbstract());

        if ($priceProductScheduleTransfers === null) {
            $this->onCreateProductAbstract($productAbstractTransfer);
        }

        return $productAbstractTransfer;
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
