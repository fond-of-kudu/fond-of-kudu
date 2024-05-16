<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Persistence;

use FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\Mapper\AttributesMapper;
use FondOfKudu\Zed\ProductAttributesCartConnector\ProductAttributesCartConnectorDependencyProvider;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ProductAttributesCartConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function getAbstractProductQuery(): SpyProductAbstractQuery
    {
        return SpyProductAbstractQuery::create();
    }

    /**
     * @return \FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\Mapper\AttributesMapper
     */
    public function getAttributesMapper()
    {
        return new AttributesMapper(
            $this->getUtilEncodingService(),
        );
    }

    /**
     * @return \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): UtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(ProductAttributesCartConnectorDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
