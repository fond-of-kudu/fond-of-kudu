<?php

namespace FondOfKudu\Zed\CountryZipcodeRestriction\Communication\Plugin\DataImport;

use FondOfKudu\Zed\CountryZipcodeRestriction\CountryZipcodeRestrictionConfig;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\DataImport\Dependency\Plugin\DataImportPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\CountryZipcodeRestriction\Business\CountryZipcodeRestrictionFacadeInterface getFacade()
 */
class CountryZipcodeRestrictionDateImportPlugin extends AbstractPlugin implements DataImportPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null
    ): DataImporterReportTransfer {
        return $this->getFacade()->import($dataImporterConfigurationTransfer);
    }

    /**
     * @return string
     */
    public function getImportType(): string
    {
        return CountryZipcodeRestrictionConfig::IMPORT_TYPE_COUNTRY_ZIPCODE_RESTRICTION;
    }
}
