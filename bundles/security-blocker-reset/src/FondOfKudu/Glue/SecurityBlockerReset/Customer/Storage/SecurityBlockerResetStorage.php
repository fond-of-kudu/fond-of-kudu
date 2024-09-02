<?php

namespace FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage;

use FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface;
use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;
use Spryker\Glue\CustomersRestApi\CustomersRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class SecurityBlockerResetStorage implements SecurityBlockerResetStorageInterface
{
    /**
     * @var \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface
     */
    protected SecurityBlockerResetClientInterface $securityBlockerClient;

    /**
     * @param \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface $securityBlockerClient
     */
    public function __construct(SecurityBlockerResetClientInterface $securityBlockerClient)
    {
        $this->securityBlockerClient = $securityBlockerClient;
    }

    /**
     * @param string $action
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return void
     */
    public function resetLoginBlock(string $action, RestRequestInterface $restRequest, RestResponseInterface $restResponse): void
    {
        if (!$this->isCustomerRestoreRequest($restRequest)) {
            return;
        }

        $securityCheckAuthContextTransfer = $this->createSecurityCheckAuthContextTransfer($restRequest);


        $this->securityBlockerClient->resetLoginBlock($securityCheckAuthContextTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return bool
     */
    protected function isCustomerRestoreRequest(RestRequestInterface $restRequest): bool
    {
        return $restRequest->getResource()->getType() === CustomersRestApiConfig::RESOURCE_CUSTOMER_RESTORE_PASSWORD
            && $restRequest->getHttpRequest()->getMethod() === Request::METHOD_POST;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\SecurityCheckAuthContextTransfer
     */
    protected function createSecurityCheckAuthContextTransfer(RestRequestInterface $restRequest): SecurityCheckAuthContextTransfer
    {
        /** @var \Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer */
        $restCustomerRestorePasswordAttributesTransfer = $restRequest->getResource()->getAttributes();

        return (new SecurityCheckAuthContextTransfer())
            ->setType('customer')
            ->setIp($restRequest->getHttpRequest()->getClientIp())
            ->setAccount($restCustomerRestorePasswordAttributesTransfer->getUsername());
    }
}
