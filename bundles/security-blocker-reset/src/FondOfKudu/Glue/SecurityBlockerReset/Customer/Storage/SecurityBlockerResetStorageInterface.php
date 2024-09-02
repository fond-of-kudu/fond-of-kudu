<?php

namespace FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage;

use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface SecurityBlockerResetStorageInterface
{
    /**
     * @param string $action
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return bool
     */
    public function resetLoginBlock(string $action, RestRequestInterface $restRequest, RestResponseInterface $restResponse): bool;
}
