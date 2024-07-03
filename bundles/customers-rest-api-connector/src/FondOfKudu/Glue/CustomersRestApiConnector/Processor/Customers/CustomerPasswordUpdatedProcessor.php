<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers;

use FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig;
use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapperInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

class CustomerPasswordUpdatedProcessor implements CustomerPasswordUpdatedProcessorInterface
{
    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface
     */
    protected CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClient;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected RestResourceBuilderInterface $restResourceBuilder;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapperInterface
     */
    protected CustomerPasswordUpdatedResourceMapperInterface $customerPasswordUpdatedResourceMapper;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface
     */
    protected RestApiErrorInterface $restApiError;

    /**
     * @param \FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClient
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapperInterface $customerPasswordUpdatedResourceMapper
     * @param \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClient,
        RestResourceBuilderInterface $restResourceBuilder,
        CustomerPasswordUpdatedResourceMapperInterface $customerPasswordUpdatedResourceMapper,
        RestApiErrorInterface $restApiError
    ) {
        $this->customerPasswordUpdateAtConnectorClient = $customerPasswordUpdateAtConnectorClient;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->customerPasswordUpdatedResourceMapper = $customerPasswordUpdatedResourceMapper;
        $this->restApiError = $restApiError;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function passwordUpdated(
        RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();
        $customerTransfer = $this->customerPasswordUpdatedResourceMapper
            ->mapRestCustomerPasswordUpdatedAttributesTransferToCustomerTransfer($restCustomerPasswordUpdatedAttributesTransfer);

        $customerPasswordUpdatedResponseTransfer = $this->customerPasswordUpdateAtConnectorClient->passwordUpdated($customerTransfer);

        if (!$customerPasswordUpdatedResponseTransfer->getIsSuccess()) {
            return $this->restApiError->addCustomerNotFoundError($restResponse);
        }

        $restResource = $this
            ->restResourceBuilder
            ->createRestResource(
                CustomersRestApiConnectorConfig::RESOURCE_CUSTOMER_PASSWORD_UPDATED,
                null,
                $customerPasswordUpdatedResponseTransfer,
            );

        return $restResponse->addResource($restResource);
    }
}
