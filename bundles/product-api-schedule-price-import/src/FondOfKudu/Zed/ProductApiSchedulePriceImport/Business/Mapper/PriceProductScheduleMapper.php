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
        return $this->createPriceProductScheduleTransfer(
            $priceProductTransfer,
            $productAbstractTransfer->getAttributes(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param array $productAbstractAttributes
     * @param int|null $idProductConcrete
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function createFromProductConcreteTransfer(
        PriceProductTransfer $priceProductTransfer,
        array $productAbstractAttributes,
        ?int $idProductConcrete = null
    ): PriceProductScheduleTransfer {
        return $this->createPriceProductScheduleTransfer(
            $priceProductTransfer,
            $productAbstractAttributes,
            $idProductConcrete,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param array $productAbstractAttributes
     * @param int|null $idProductConcrete
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    protected function createPriceProductScheduleTransfer(
        PriceProductTransfer $priceProductTransfer,
        array $productAbstractAttributes,
        ?int $idProductConcrete = null
    ): PriceProductScheduleTransfer {
        $specialPriceFrom = $productAbstractAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAbstractAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productAbstractAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];

        $priceProductTransfer->getMoneyValue()->setGrossAmount($specialPrice);

        if ($idProductConcrete !== null) {
            $priceProductTransfer->setIdProduct($idProductConcrete);
        }

        $priceProductScheduleListTransfer = (new PriceProductScheduleListTransfer())
            ->setIdPriceProductScheduleList($this->apiSchedulePriceImportConfig->getIdPriceProductScheduleList());

        $priceTypeTransfer = $this->priceProductFacade->findPriceTypeByName(
            $this->apiSchedulePriceImportConfig->getPriceDimensionRrp(),
        );

        return (new PriceProductScheduleTransfer())
            ->setActiveFrom($specialPriceFrom)
            ->setActiveTo($specialPriceTo)
            ->setPriceProductScheduleList($priceProductScheduleListTransfer)
            ->setStore($priceProductTransfer->getMoneyValue()->getStore())
            ->setPriceProduct($priceProductTransfer->setPriceType($priceTypeTransfer))
            ->setCurrency($priceProductTransfer->getMoneyValue()->getCurrency());
    }
}
