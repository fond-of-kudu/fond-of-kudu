<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use Generated\Shared\Transfer\PriceProductScheduleListTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class PriceProductScheduleMapper implements PriceProductScheduleMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function fromProductAbstractTransfer(
        ProductAbstractTransfer $productAbstractTransfer
    ): PriceProductScheduleTransfer {
        $productAttributes = $productAbstractTransfer->getAttributes();
        $specialPriceFrom = $productAttributes[ProductApiSchedulePriceImportConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM];
        $specialPriceTo = $productAttributes[ProductApiSchedulePriceImportConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO];

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
