<?php


namespace FondOfKudu\Zed\CountryZipcodeRestrictionImport;

use Orm\Zed\CountryZipcodeRestriction\Persistence\FokCountryZipcodeRestrictionQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CountryZipcodeRestrictionImportDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_COUNTRY_ZIPCODE_RESTRICTION = 'PROPEL_QUERY_COUNTRY_ZIPCODE_RESTRICTION';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addCountryZipcodeRestrictionPropelQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCountryZipcodeRestrictionPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COUNTRY_ZIPCODE_RESTRICTION] = fn (): FokCountryZipcodeRestrictionQuery => FokCountryZipcodeRestrictionQuery::create();

        return $container;
    }
}
