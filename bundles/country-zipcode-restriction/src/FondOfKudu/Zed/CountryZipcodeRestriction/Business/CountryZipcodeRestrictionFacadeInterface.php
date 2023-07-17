<?php

namespace FondOfKudu\Zed\CountryZipcodeRestriction\Business;

use Generated\Shared\Transfer\CountryZipcodeRestrictionTransfer;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;

interface CountryZipcodeRestrictionFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CountryZipcodeRestrictionTransfer $checkoutRegionRestrictionTransfer
     *
     * @return \Generated\Shared\Transfer\CountryZipcodeRestrictionTransfer
     */
    public function validateRegion(
        CountryZipcodeRestrictionTransfer $checkoutRegionRestrictionTransfer
    ): CountryZipcodeRestrictionTransfer;

    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return void
     */
    public function import(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): void;
}
