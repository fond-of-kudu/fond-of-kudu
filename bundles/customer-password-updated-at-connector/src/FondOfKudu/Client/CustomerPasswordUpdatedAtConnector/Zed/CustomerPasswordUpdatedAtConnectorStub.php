<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed;

use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CustomerPasswordUpdatedAtConnectorStub implements CustomerPasswordUpdatedAtConnectorStubInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected ZedRequestClientInterface $zedStub;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedStub
     */
    public function __construct(ZedRequestClientInterface $zedStub)
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
