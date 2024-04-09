<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use Generated\Shared\Transfer\ProductConcreteTransfer;

interface ProductConcreteMapperInterface
{
    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function fromArray(array $data): ProductConcreteTransfer;
}
