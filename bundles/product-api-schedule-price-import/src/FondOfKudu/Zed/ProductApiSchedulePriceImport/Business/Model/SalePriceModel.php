<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class SalePriceModel
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractHandlerInterface
     */
    protected SalePriceProductAbstractHandlerInterface $salePriceProductAbstractHandler;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductConcreteHandlerInterface
     */
    protected SalePriceProductConcreteHandlerInterface $salePriceProductConcreteHandler;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $productApiSchedulePriceImportConfig;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractHandlerInterface $salePriceProductAbstractHandler
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductConcreteHandlerInterface $salePriceProductConcreteHandler
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $productApiSchedulePriceImportConfig
     */
    public function __construct(
        SalePriceProductAbstractHandlerInterface $salePriceProductAbstractHandler,
        SalePriceProductConcreteHandlerInterface $salePriceProductConcreteHandler,
        ProductApiSchedulePriceImportConfig $productApiSchedulePriceImportConfig
    ) {
        $this->salePriceProductAbstractHandler = $salePriceProductAbstractHandler;
        $this->salePriceProductConcreteHandler = $salePriceProductConcreteHandler;
        $this->productApiSchedulePriceImportConfig = $productApiSchedulePriceImportConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handle(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        $attributes = $productAbstractTransfer->getAttributes();

        if (!$this->validateSpecialPriceAttributes($attributes)) {
            return $productAbstractTransfer;
        }

        $this->salePriceProductAbstractHandler->handle($productAbstractTransfer);

        foreach ($productAbstractTransfer->getProductConcretes() as $productConcreteTransfer) {
            $this->salePriceProductConcreteHandler->handle($productConcreteTransfer, $attributes);
        }

        return $productAbstractTransfer;
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    protected function validateSpecialPriceAttributes(array $attributes): bool
    {
        $required = [
            $this->productApiSchedulePriceImportConfig->getProductAttributeSalePrice(),
            $this->productApiSchedulePriceImportConfig->getProductAttributeSalePriceFrom(),
            $this->productApiSchedulePriceImportConfig->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $item) {
            if (!isset($attributes[$item])) {
                return false;
            }

            if (!$attributes[$item]) {
                return false;
            }
        }

        return true;
    }
}
