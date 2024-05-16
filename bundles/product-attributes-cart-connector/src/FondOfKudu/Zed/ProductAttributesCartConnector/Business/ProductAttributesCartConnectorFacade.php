<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Business;

use Generated\Shared\Transfer\CartChangeTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\ProductAttributesCartConnector\Business\ProductAttributesCartConnectorBusinessFactory getFactory()
 */
class ProductAttributesCartConnectorFacade extends AbstractFacade implements ProductAttributesCartConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        return $this->getFactory()
            ->createProductExpander()
            ->expandItems($cartChangeTransfer);
    }
}
