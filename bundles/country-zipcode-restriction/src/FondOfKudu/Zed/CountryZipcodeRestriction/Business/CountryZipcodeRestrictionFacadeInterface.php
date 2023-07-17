<?php

namespace FondOfKudu\Zed\CountryZipcodeRestriction\Business;

use Generated\Shared\Transfer\CountryZipcodeRestrictionTransfer;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;

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
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null
    ): DataImporterReportTransfer;
}
