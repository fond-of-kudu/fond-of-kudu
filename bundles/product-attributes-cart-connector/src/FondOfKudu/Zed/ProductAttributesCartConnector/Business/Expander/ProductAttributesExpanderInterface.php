<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Business\Expander;

use Generated\Shared\Transfer\CartChangeTransfer;

interface ProductAttributesExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer;
}
