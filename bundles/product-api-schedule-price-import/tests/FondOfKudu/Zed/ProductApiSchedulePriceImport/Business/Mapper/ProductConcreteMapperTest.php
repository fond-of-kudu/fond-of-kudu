<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class ProductConcreteMapperTest extends Unit
{
    protected ProductConcreteMapper $productConcreteMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productConcreteMapper = new ProductConcreteMapper();
    }

    /**
     * @return void
     */
    public function testFromArray(): void
    {
        $productConcreteTransfer = $this->productConcreteMapper->fromArray([
            ProductConcreteTransfer::ID_PRODUCT_CONCRETE => 99,
            ProductConcreteTransfer::SKU => 'SKU-000-000',
        ]);

        static::assertEquals($productConcreteTransfer->getIdProductConcrete(), 99);
        static::assertEquals($productConcreteTransfer->getSku(), 'SKU-000-000');
    }
}
