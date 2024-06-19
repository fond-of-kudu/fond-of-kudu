<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorFactory getFactory()
 */
class CustomerPasswordUpdatedAtConnectorClient extends AbstractClient implements CustomerPasswordUpdatedAtConnectorClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer)
    {
        return $this->getFactory()
            ->createZedCustomerStub()
            ->restorePassword($customerTransfer);
    }
}
