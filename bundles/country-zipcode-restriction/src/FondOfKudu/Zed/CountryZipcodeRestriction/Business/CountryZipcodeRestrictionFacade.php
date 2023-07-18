<?php

namespace FondOfKudu\Zed\CountryZipcodeRestriction\Business;

use Generated\Shared\Transfer\CountryZipcodeRestrictionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\CountryZipcodeRestriction\Business\CountryZipcodeRestrictionBusinessFactory getFactory()
 */
class CountryZipcodeRestrictionFacade extends AbstractFacade implements CountryZipcodeRestrictionFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CountryZipcodeRestrictionTransfer $checkoutRegionRestrictionTransfer
     *
     * @return \Generated\Shared\Transfer\CountryZipcodeRestrictionTransfer
     */
    public function validateRegion(
        CountryZipcodeRestrictionTransfer $checkoutRegionRestrictionTransfer
    ): CountryZipcodeRestrictionTransfer {
        return $checkoutRegionRestrictionTransfer;
    }
}
