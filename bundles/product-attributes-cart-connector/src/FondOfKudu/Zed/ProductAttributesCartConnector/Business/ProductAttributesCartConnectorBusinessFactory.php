<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Business;

use FondOfKudu\Zed\ProductAttributesCartConnector\Business\Expander\ProductAttributesExpander;
use FondOfKudu\Zed\ProductAttributesCartConnector\Business\Expander\ProductAttributesExpanderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\ProductAttributesCartConnectorRepository getRepository()()
 */
class ProductAttributesCartConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\ProductAttributesCartConnector\Business\Expander\ProductAttributesExpanderInterface
     */
    public function createProductExpander(): ProductAttributesExpanderInterface
    {
        return new ProductAttributesExpander(
            $this->getRepository(),
        );
    }
}
