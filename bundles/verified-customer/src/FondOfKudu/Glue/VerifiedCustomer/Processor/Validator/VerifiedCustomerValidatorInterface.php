<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Processor\Validator;

use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface VerifiedCustomerValidatorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErrorMessageTransfer|null
     */
    public function isVerified(RestRequestInterface $restRequest): ?RestErrorMessageTransfer;
}
