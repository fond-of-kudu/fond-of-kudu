<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorBusinessFactory getFactory()
 */
class CustomerPasswordUpdatedAtConnectorFacade extends AbstractFacade implements CustomerPasswordUpdatedAtConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        return $this->getFactory()
            ->createCustomerRestorePassword()
            ->restorePassword($customerTransfer);
    }
}
