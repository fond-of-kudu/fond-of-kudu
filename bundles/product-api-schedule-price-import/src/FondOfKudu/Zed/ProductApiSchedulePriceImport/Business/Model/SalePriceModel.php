<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\ProductConcreteMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class SalePriceModel implements SalePriceModelInterface
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
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\ProductConcreteMapperInterface
     */
    protected ProductConcreteMapperInterface $productConcreteMapper;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractHandlerInterface $salePriceProductAbstractHandler
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductConcreteHandlerInterface $salePriceProductConcreteHandler
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\ProductConcreteMapperInterface $productConcreteMapper
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $productApiSchedulePriceImportConfig
     */
    public function __construct(
        SalePriceProductAbstractHandlerInterface $salePriceProductAbstractHandler,
        SalePriceProductConcreteHandlerInterface $salePriceProductConcreteHandler,
        ProductConcreteMapperInterface $productConcreteMapper,
        ProductApiSchedulePriceImportConfig $productApiSchedulePriceImportConfig
    ) {
        $this->salePriceProductAbstractHandler = $salePriceProductAbstractHandler;
        $this->salePriceProductConcreteHandler = $salePriceProductConcreteHandler;
        $this->productApiSchedulePriceImportConfig = $productApiSchedulePriceImportConfig;
        $this->productConcreteMapper = $productConcreteMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handle(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        $productAbstractAttributes = $productAbstractTransfer->getAttributes();

        if (!$this->validateSpecialPriceAttributes($productAbstractAttributes)) {
            return $productAbstractTransfer;
        }

        $this->salePriceProductAbstractHandler->handle($productAbstractTransfer);

        foreach ($productAbstractTransfer->getProductConcretes() as $productConcreteData) {
            $productConcreteTransfer = $this->productConcreteMapper->fromArray($productConcreteData);

            $this->salePriceProductConcreteHandler->handle($productConcreteTransfer, $productAbstractAttributes);
        }

        return $productAbstractTransfer;
    }

    /**
     * @param array $productAbstractAttributes
     *
     * @return bool
     */
    protected function validateSpecialPriceAttributes(array $productAbstractAttributes): bool
    {
        $required = [
            $this->productApiSchedulePriceImportConfig->getProductAttributeSalePrice(),
            $this->productApiSchedulePriceImportConfig->getProductAttributeSalePriceFrom(),
            $this->productApiSchedulePriceImportConfig->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $item) {
            if (!isset($productAbstractAttributes[$item])) {
                return false;
            }

            if (!$productAbstractAttributes[$item]) {
                return false;
            }
        }

        return true;
    }
}
