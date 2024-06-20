<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers;

use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapperInterface;
use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

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
     * @param \FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClient
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapperInterface $customerPasswordUpdatedResourceMapper
     */
    public function __construct(
        CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClient,
        RestResourceBuilderInterface $restResourceBuilder,
        CustomerPasswordUpdatedResourceMapperInterface $customerPasswordUpdatedResourceMapper
    ) {
        $this->customerPasswordUpdateAtConnectorClient = $customerPasswordUpdateAtConnectorClient;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->customerPasswordUpdatedResourceMapper = $customerPasswordUpdatedResourceMapper;
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
            foreach ($customerPasswordUpdatedResponseTransfer->getErrors() as $error) {
                $restResponse->addError((new RestErrorMessageTransfer())
                    ->setCode('1000')
                    ->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
                    ->setDetail($error->getMessage()));
            }

            return $restResponse;
        }

        $restResource = $this
            ->restResourceBuilder
            ->createRestResource(
                'password-updated',
                null,
                $customerPasswordUpdatedResponseTransfer,
            );

        return $restResponse->addResource($restResource);
    }
}
