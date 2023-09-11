<?php

namespace FondOfKudu\Zed\CheckoutRestApi\Business\Checkout;

use FondOfKudu\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutResponseTransfer;
use Spryker\Zed\CheckoutRestApi\Business\Checkout\PlaceOrderProcessor as SprykerPlaceOrderProcessor;
use Spryker\Zed\CheckoutRestApi\Business\Validator\CheckoutValidatorInterface;
use Spryker\Zed\CheckoutRestApi\CheckoutRestApiConfig as ZedCheckoutRestApiConfig;
use Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToCalculationFacadeInterface;
use Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToCheckoutFacadeInterface;

class PlaceOrderProcessor extends SprykerPlaceOrderProcessor
{
    /**
     * @var \FondOfKudu\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToQuoteFacadeInterface
     */
    protected $quoteFacade;

    /**
     * @param \Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToCheckoutFacadeInterface $checkoutFacade
     * @param \FondOfKudu\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToQuoteFacadeInterface $quoteFacade
     * @param \Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToCalculationFacadeInterface $calculationFacade
     * @param \Spryker\Zed\CheckoutRestApi\Business\Validator\CheckoutValidatorInterface $checkoutValidator
     * @param array $quoteMapperPlugins
     * @param \Spryker\Zed\CheckoutRestApi\CheckoutRestApiConfig $config
     */
    public function __construct(
        CheckoutRestApiToCheckoutFacadeInterface $checkoutFacade,
        CheckoutRestApiToQuoteFacadeInterface $quoteFacade,
        CheckoutRestApiToCalculationFacadeInterface $calculationFacade,
        CheckoutValidatorInterface $checkoutValidator,
        array $quoteMapperPlugins,
        ZedCheckoutRestApiConfig $config
    ) {
        parent::__construct($checkoutFacade, $quoteFacade, $calculationFacade, $checkoutValidator, $quoteMapperPlugins, $config);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutResponseTransfer
     */
    protected function placeOrderWithCartRemoval(QuoteTransfer $quoteTransfer): RestCheckoutResponseTransfer
    {
        $checkoutResponseTransfer = parent::placeOrderWithCartRemoval($quoteTransfer);

        if (!$this->config->deleteCartAfterOrderCreation()) {
            $quoteTransfer->setOrderReference($checkoutResponseTransfer->getOrderReference());

            $this->quoteFacade->updateQuote($quoteTransfer);
        }

        return $checkoutResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutResponseTransfer
     */
    protected function createRestCheckoutResponseTransfer(CheckoutResponseTransfer $checkoutResponseTransfer): RestCheckoutResponseTransfer
    {
        $restCheckoutResponseTransfer = parent::createRestCheckoutResponseTransfer($checkoutResponseTransfer);

        $restCheckoutResponseTransfer->setBackUrl($checkoutResponseTransfer->getBackUrl());

        return $restCheckoutResponseTransfer;
    }
}
