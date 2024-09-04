<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Processor\Validator;

use FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerInterface;
use FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestErrorCollectionTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class VerifiedCustomerValidator implements VerifiedCustomerValidatorInterface
{
    /**
     * @var \FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerInterface
     */
    protected VerifiedCustomerToCustomerInterface $customerClient;

    /**
     * @var \FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerConfig
     */
    protected VerifiedCustomerConfig $config;

    /**
     * @param \FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerInterface $customerClient
     */
    public function __construct(
        VerifiedCustomerToCustomerInterface $customerClient
    ) {
        $this->customerClient = $customerClient;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErrorCollectionTransfer|null
     */
    public function isVerified(RestRequestInterface $restRequest): ?RestErrorCollectionTransfer
    {
        if ($this->isProtectedResource($restRequest) === false) {
            return null;
        }

        $restUser = $restRequest->getRestUser();
        if ($restUser === null) {
            return null;
        }

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->setCustomerReference($restUser->getNaturalIdentifier());

        $customerResponseTransfer = $this->customerClient->findCustomerByReference($customerTransfer);

        $customerTransfer = $customerResponseTransfer->getCustomerTransfer();

        if ($customerTransfer->getRegistered() === null && $customerTransfer->getRegistrationKey() !== null) {
            return $this->createRestErrorCollection();
        }

        return null;
    }

    /**
     * @return \Generated\Shared\Transfer\RestErrorCollectionTransfer
     */
    protected function createRestErrorCollection(): RestErrorCollectionTransfer
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_FORBIDDEN)
            ->setCode(VerifiedCustomerConfig::CUSTOMER_NOT_VERIFIED_ERROR_CODE)
            ->setDetail('Customer is not verified.');

        return (new RestErrorCollectionTransfer())
            ->addRestError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return bool
     */
    protected function isProtectedResource(RestRequestInterface $restRequest): bool
    {
        $restUser = $restRequest->getRestUser();
        if (!$restUser) {
            return false;
        }

        $customerResource = $restRequest->findParentResourceByType(VerifiedCustomerConfig::RESOURCE_CUSTOMERS);

        if (!$customerResource) {
            return false;
        }

        return $restUser->getNaturalIdentifier() === $customerResource->getId();
    }
}
