<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Business;

use Generated\Shared\Transfer\CartChangeTransfer;

interface ProductAttributesCartConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer;
}
