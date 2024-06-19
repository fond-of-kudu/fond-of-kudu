<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;

interface CustomerRestorePasswordResourceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapCustomerRestorePasswordAttributesToCustomerTransfer(
        RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer
    ): CustomerTransfer;
}
