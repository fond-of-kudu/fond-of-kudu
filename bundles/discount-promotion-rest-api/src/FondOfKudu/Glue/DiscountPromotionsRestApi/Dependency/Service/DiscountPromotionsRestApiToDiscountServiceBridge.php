<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service;

use Generated\Shared\Transfer\DiscountCalculationRequestTransfer;
use Generated\Shared\Transfer\DiscountCalculationResponseTransfer;
use Spryker\Service\Discount\DiscountServiceInterface;

class DiscountPromotionsRestApiToDiscountServiceBridge implements DiscountPromotionsRestApiToDiscountServiceInterface
{
    /**
     * @var \Spryker\Service\Discount\DiscountServiceInterface
     */
    protected $discountService;

    /**
     * @param \Spryker\Service\Discount\DiscountServiceInterface $discountService
     */
    public function __construct(DiscountServiceInterface $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * @param \Generated\Shared\Transfer\DiscountCalculationRequestTransfer $discountCalculationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\DiscountCalculationResponseTransfer
     */
    public function calculate(DiscountCalculationRequestTransfer $discountCalculationRequestTransfer): DiscountCalculationResponseTransfer
    {
        return $this->discountService->calculate($discountCalculationRequestTransfer);
    }
}
