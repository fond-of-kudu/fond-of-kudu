<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed;

use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

class CustomerPasswordUpdatedAtConnectorStub implements CustomerPasswordUpdatedAtConnectorStubInterface
{
    /**
     * @var \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface
     */
    protected CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface $zedStub;

    /**
     * @param \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface $zedStub
     */
    public function __construct(CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface $zedStub)
    {
        $this->zedStub = $zedStub;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer */
        $customerResponseTransfer = $this->zedStub->call('/customer-password-updated-at-connector/gateway/restore-password', $customerTransfer);

        return $customerResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    public function passwordUpdated(CustomerTransfer $customerTransfer): CustomerPasswordUpdatedResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransfer */
        $customerPasswordUpdatedResponseTransfer = $this->zedStub->call(
            '/customer-password-updated-at-connector/gateway/password-updated',
            $customerTransfer,
        );

        return $customerPasswordUpdatedResponseTransfer;
    }
}
