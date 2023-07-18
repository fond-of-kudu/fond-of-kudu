<?php

namespace FondOfKudu\Zed\CountryZipcodeRestrictionImport\Business;

use FondOfKudu\Zed\CountryZipcodeRestrictionImport\CountryZipcodeRestrictionImportDependencyProvider;
use Orm\Zed\CountryZipcodeRestriction\Persistence\FokCountryZipcodeRestrictionQuery;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CountryZipcodeRestrictionImportBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Orm\Zed\CountryZipcodeRestriction\Persistence\FokCountryZipcodeRestrictionQuery
     */
    public function getCountryZipcodeRestrictionPropelQuery(): FokCountryZipcodeRestrictionQuery
    {
        return $this->getProvidedDependency(CountryZipcodeRestrictionImportDependencyProvider::PROPEL_QUERY_COUNTRY_ZIPCODE_RESTRICTION);
    }
}
