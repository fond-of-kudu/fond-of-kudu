<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Processor\Validator;

use Generated\Shared\Transfer\RestErrorCollectionTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;

interface VerifiedCustomerValidatorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErrorCollectionTransfer|null
     */
    public function isVerified(RestRequest $restRequest): ?RestErrorCollectionTransfer;
}
