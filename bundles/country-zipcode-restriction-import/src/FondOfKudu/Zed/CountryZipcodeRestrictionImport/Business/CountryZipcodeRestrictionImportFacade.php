<?php

namespace FondOfKudu\Zed\CountryZipcodeRestrictionImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\CountryZipcodeRestriction\Business\CountryZipcodeRestrictionBusinessFactory getFactory()
 */
class CountryZipcodeRestrictionImportFacade extends AbstractFacade implements CountryZipcodeRestrictionImportFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null
    ): DataImporterReportTransfer {
        return new DataImporterReportTransfer();
    }
}
