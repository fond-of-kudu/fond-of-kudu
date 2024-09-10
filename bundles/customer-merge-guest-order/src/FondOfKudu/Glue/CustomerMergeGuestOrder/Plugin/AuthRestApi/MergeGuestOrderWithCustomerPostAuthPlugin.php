<?php

namespace FondOfKudu\Glue\CustomerMergeGuestOrder\Plugin\AuthRestApi;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OauthResponseTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;
use Spryker\Zed\AuthRestApiExtension\Dependency\Plugin\PostAuthPluginInterface;

/**
 * @method \FondOfKudu\Glue\CustomerMergeGuestOrder\CustomerMergeGuestOrderFactory getFactory()
 */
class MergeGuestOrderWithCustomerPostAuthPlugin extends AbstractPlugin implements PostAuthPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\OauthResponseTransfer $oauthResponseTransfer
     *
     * @return void
     */
    public function postAuth(OauthResponseTransfer $oauthResponseTransfer): void
    {
        $customerTransfer = (new CustomerTransfer())->setCustomerReference($oauthResponseTransfer->getCustomerReference());
        $this->getFactory()->createOrderUpdater()->updateGuestOrder($customerTransfer);
    }
}
