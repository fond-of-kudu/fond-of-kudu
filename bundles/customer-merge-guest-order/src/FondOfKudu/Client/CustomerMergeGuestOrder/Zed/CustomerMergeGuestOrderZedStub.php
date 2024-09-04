<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CartsRestApi\Zed;

use FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CustomerMergeGuestOrderZedStub implements CustomerMergeGuestOrderZedStubInterface
{
    /**
     * @var \FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface
     */
    protected CustomerMergeGuestOrderToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CustomerMergeGuestOrderToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @uses \Spryker\Zed\CartsRestApi\Communication\Controller\GatewayController::findQuoteByUuidAction()
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function findQuoteByUuid(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\QuoteResponseTransfer $quoteResponseTransfer */
        $quoteResponseTransfer = $this->zedRequestClient->call('/carts-rest-api/gateway/find-quote-by-uuid', $quoteTransfer);

        return $quoteResponseTransfer;
    }
}
