<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;

interface CustomerPasswordUpdatedResourceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapRestCustomerPasswordUpdatedAttributesTransferToCustomerTransfer(
        RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer
    ): CustomerTransfer;
}
