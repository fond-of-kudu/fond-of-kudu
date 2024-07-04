<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper;

use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerPasswordUpdatedRestResponseTransfer;

class CustomerPasswordUpdatedRestResponseMapper implements CustomerPasswordUpdatedRestResponseMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerPasswordUpdatedRestResponseTransfer
     */
    public function mapCustomerPasswordUpdatedRestResponseFromCustomerPasswordUpdatedResponse(
        CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransfer
    ): CustomerPasswordUpdatedRestResponseTransfer {
        return (new CustomerPasswordUpdatedRestResponseTransfer())->fromArray(
            $customerPasswordUpdatedResponseTransfer->toArray(),
            true,
        );
    }
}
