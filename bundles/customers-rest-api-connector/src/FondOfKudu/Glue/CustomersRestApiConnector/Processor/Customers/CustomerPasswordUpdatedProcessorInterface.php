<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers;

use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface CustomerPasswordUpdatedProcessorInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function passwordUpdated(
        RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer
    ): RestResponseInterface;
}
