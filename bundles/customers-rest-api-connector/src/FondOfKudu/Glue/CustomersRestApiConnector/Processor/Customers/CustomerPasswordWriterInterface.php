<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers;

use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface CustomerPasswordWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function restorePassword(RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer): RestResponseInterface;
}
