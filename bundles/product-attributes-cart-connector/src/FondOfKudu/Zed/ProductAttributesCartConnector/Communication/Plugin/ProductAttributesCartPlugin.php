<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Communication\Plugin;

use Generated\Shared\Transfer\CartChangeTransfer;
use Spryker\Zed\CartExtension\Dependency\Plugin\ItemExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\ProductAttributesCartConnector\Business\ProductAttributesCartConnectorFacadeInterface getFacade()
 */
class ProductAttributesCartPlugin extends AbstractPlugin implements ItemExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        $this->getFacade()->expandItems($cartChangeTransfer);

        return $cartChangeTransfer;
    }
}
