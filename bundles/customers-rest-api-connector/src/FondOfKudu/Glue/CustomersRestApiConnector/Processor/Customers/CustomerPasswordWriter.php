<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers;

use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class CustomerPasswordWriter implements CustomerPasswordWriterInterface
{
    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface
     */
    protected CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClient;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface
     */
    protected CustomerRestorePasswordResourceMapperInterface $customerRestorePasswordResourceMapper;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface
     */
    protected RestApiErrorInterface $restApiError;

    /**
     * @param \FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClient
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface $customerRestorePasswordResourceMapper
     * @param \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClient,
        RestResourceBuilderInterface $restResourceBuilder,
        CustomerRestorePasswordResourceMapperInterface $customerRestorePasswordResourceMapper,
        RestApiErrorInterface $restApiError
    ) {
        $this->customerPasswordUpdateAtConnectorClient = $customerPasswordUpdateAtConnectorClient;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->customerRestorePasswordResourceMapper = $customerRestorePasswordResourceMapper;
        $this->restApiError = $restApiError;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function restorePassword(RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        if ($restCustomerRestorePasswordAttributesTransfer->getPassword() !== $restCustomerRestorePasswordAttributesTransfer->getConfirmPassword()) {
            return $this->restApiError->addPasswordsDoNotMatchError(
                $restResponse,
                RestCustomerRestorePasswordAttributesTransfer::PASSWORD,
                RestCustomerRestorePasswordAttributesTransfer::CONFIRM_PASSWORD,
            );
        }

        $customerTransfer = $this->customerRestorePasswordResourceMapper
            ->mapCustomerRestorePasswordAttributesToCustomerTransfer($restCustomerRestorePasswordAttributesTransfer);
        $customerResponseTransfer = $this->customerPasswordUpdateAtConnectorClient->restorePassword($customerTransfer);

        if (!$customerResponseTransfer->getIsSuccess()) {
            return $this->restApiError->processCustomerErrorOnPasswordReset($restResponse, $customerResponseTransfer);
        }

        return $restResponse->setStatus(Response::HTTP_NO_CONTENT);
    }
}
