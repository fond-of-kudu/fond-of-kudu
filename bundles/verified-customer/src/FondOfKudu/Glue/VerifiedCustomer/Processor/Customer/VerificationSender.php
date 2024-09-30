<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Processor\Customer;

use FondOfKudu\Client\VerifiedCustomer\VerifiedCustomerClientInterface;
use FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class VerificationSender implements VerificationSenderInterface
{
    /**
     * @var \FondOfKudu\Client\VerifiedCustomer\VerifiedCustomerClientInterface
     */
    protected VerifiedCustomerClientInterface $verifiedCustomerClient;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected RestResourceBuilderInterface $restResourceBuilder;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfKudu\Client\VerifiedCustomer\VerifiedCustomerClientInterface $verifiedCustomerClient
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        VerifiedCustomerClientInterface $verifiedCustomerClient
    ) {
        $this->verifiedCustomerClient = $verifiedCustomerClient;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function resendAccountVerification(RestRequestInterface $restRequest): RestResponseInterface
    {
        $customer = (new CustomerTransfer())->setCustomerReference($restRequest->getRestUser()->getNaturalIdentifier());

        $verifiedCustomerResponseTransfer = $this->verifiedCustomerClient->resendAccountVerification($customer);

        return $verifiedCustomerResponseTransfer->getSuccess() ? $this->createNoContentResponse() : $this->createRestError();
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createNoContentResponse(): RestResponseInterface
    {
        return $this->restResourceBuilder->createRestResponse()
            ->setStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createRestError(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(VerifiedCustomerConfig::CUSTOMER_ALREADY_VERIFIED_CODE)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(VerifiedCustomerConfig::CUSTOMER_ALREADY_VERIFIED_DETAIL);

        return $this->restResourceBuilder->createRestResponse()->addError($restErrorMessageTransfer);
    }
}
