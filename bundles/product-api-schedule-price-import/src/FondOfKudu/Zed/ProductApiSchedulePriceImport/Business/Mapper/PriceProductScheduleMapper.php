<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleListTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class PriceProductScheduleMapper implements PriceProductScheduleMapperInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(
        ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
    ) {
        $this->priceProductFacade = $priceProductFacade;
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function createFromProductAbstractTransfer(
        ProductAbstractTransfer $productAbstractTransfer,
        PriceProductTransfer $priceProductTransfer
    ): PriceProductScheduleTransfer {
        $productAttributes = $productAbstractTransfer->getAttributes();
        $specialPriceFrom = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];
        $priceProductTransfer->getMoneyValue()->setGrossAmount($specialPrice);

        $priceProductScheduleListTransfer = (new PriceProductScheduleListTransfer())
            ->setIdPriceProductScheduleList($this->apiSchedulePriceImportConfig->getIdPriceProductScheduleList());

        $priceTypeTransfer = $this->priceProductFacade->findPriceTypeByName(
            $this->apiSchedulePriceImportConfig->getPriceDimensionRrp(),
        );

        $priceProductScheduleTransfer = (new PriceProductScheduleTransfer())
            ->setActiveFrom($specialPriceFrom)
            ->setActiveTo($specialPriceTo)
            ->setPriceProductScheduleList($priceProductScheduleListTransfer)
            ->setStore($priceProductTransfer->getMoneyValue()->getStore())
            ->setPriceProduct($priceProductTransfer->setPriceType($priceTypeTransfer))
            ->setCurrency($priceProductTransfer->getMoneyValue()->getCurrency());

        return $priceProductScheduleTransfer;
    }
}
