<?php

namespace FondOfKudu\Zed\CartsRestApi\Business\PermissionChecker;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CartsRestApi\Business\PermissionChecker\QuotePermissionChecker as SprykerQuotePermissionChecker;

class QuotePermissionChecker extends SprykerQuotePermissionChecker
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $permissionPluginKey
     *
     * @return bool
     */
    protected function checkQuotePermission(QuoteTransfer $quoteTransfer, string $permissionPluginKey): bool
    {
        if (!$quoteTransfer->getCustomer()) {
            return false;
        }

        if ($quoteTransfer->getCustomer()->getCustomerReference() === $quoteTransfer->getCartCustomerReference()) {
            return true;
        }

        return parent::checkQuotePermission($quoteTransfer, $permissionPluginKey);
    }
}
