<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleListTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class PriceProductScheduleMapper implements PriceProductScheduleMapperInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig)
    {
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function fromProductAbstractTransfer(
        ProductAbstractTransfer $productAbstractTransfer
    ): PriceProductScheduleTransfer {
        $productAttributes = $productAbstractTransfer->getAttributes();
        $specialPriceFrom = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];

        $priceProductScheduleListTransfer = (new PriceProductScheduleListTransfer())->setIdPriceProductScheduleList(1);
        $priceProductScheduleTransfer = new PriceProductScheduleTransfer();
        $priceProductScheduleTransfer->setPriceProductScheduleList($priceProductScheduleListTransfer);
        $priceProductScheduleTransfer->setActiveFrom($specialPriceFrom);
        $priceProductScheduleTransfer->setActiveTo($specialPriceTo);

        foreach ($productAbstractTransfer->getStoreRelation()->getStores() as $storeTransfer) {
            $priceProductScheduleTransfer->setStore($storeTransfer);

            break;
        }

        foreach ($productAbstractTransfer->getPrices() as $priceProductTransfer) {
            $priceProductScheduleTransfer->setPriceProduct($priceProductTransfer);
            $priceProductScheduleTransfer->setCurrency($priceProductTransfer->getMoneyValue()->getCurrency());

            break;
        }

        return $priceProductScheduleTransfer;
    }
}
