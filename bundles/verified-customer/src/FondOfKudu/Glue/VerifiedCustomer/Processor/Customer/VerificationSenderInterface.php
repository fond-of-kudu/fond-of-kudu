<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Processor\Customer;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;

interface VerificationSenderInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function resendAccountVerification(RestRequest $restRequest): RestResponseInterface;
}
