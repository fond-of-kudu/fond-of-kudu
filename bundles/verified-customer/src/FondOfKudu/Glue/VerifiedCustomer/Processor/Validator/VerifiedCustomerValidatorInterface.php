<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Processor\Validator;

use Generated\Shared\Transfer\RestErrorCollectionTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface VerifiedCustomerValidatorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErrorCollectionTransfer|null
     */
    public function isVerified(RestRequestInterface $restRequest): ?RestErrorCollectionTransfer;
}
