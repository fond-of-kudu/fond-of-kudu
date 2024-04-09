<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use Generated\Shared\Transfer\ProductConcreteTransfer;

class ProductConcreteMapper implements ProductConcreteMapperInterface
{
    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function fromArray(array $data): ProductConcreteTransfer
    {
        return (new ProductConcreteTransfer())->fromArray($data, true);
    }
}
