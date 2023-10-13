<?php

namespace FondOfKudu\Zed\CartsRestApi\Communication\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;
use Spryker\Glue\CartsRestApiExtension\Dependency\Plugin\RestCartAttributesMapperPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \Spryker\Zed\CartsRestApi\CartsRestApiConfig getConfig()
 * @method \Spryker\Glue\CartsRestApi\CartsRestApiFactory getFactory()
 * @method \FondOfKudu\Client\CartsRestApi\CartsRestApiClientInterface getClient()
 * @method \FondOfKudu\Zed\CartsRestApi\Business\CartsRestApiFacadeInterface getFacade()
 */
class ResetCartAttributesMapperPlugin extends AbstractPlugin implements RestCartAttributesMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCartsAttributesTransfer $restCartsAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartsAttributesTransfer
     */
    public function mapQuoteTransferToRestCartAttributesTransfer(
        QuoteTransfer $quoteTransfer,
        RestCartsAttributesTransfer $restCartsAttributesTransfer
    ): RestCartsAttributesTransfer {
        $hasSalesOrderItemId = false;

        foreach ($quoteTransfer->getItems() as $item) {
            if ($item->getIdSalesOrderItem()) {
                $hasSalesOrderItemId = true;
                break;
            }
        }

        if (!$quoteTransfer->getOrderReference() && !$hasSalesOrderItemId) {
            return $restCartsAttributesTransfer;
        }

        $this->getClient()->resetQuote($quoteTransfer);

        return $restCartsAttributesTransfer;
    }
}
