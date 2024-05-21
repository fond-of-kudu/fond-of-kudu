<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\ProductAttributesCartConnectorPersistenceFactory getFactory()
 */
class ProductAttributesCartConnectorRepository extends AbstractRepository
{
    /**
     * @param array $idsProductAbstract
     *
     * @return array
     */
    public function getProductAbstractAttributes(array $idsProductAbstract): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $entities */
        $entities = $this->getFactory()
            ->getAbstractProductQuery()
            ->filterByIdProductAbstract_In($idsProductAbstract)
            ->find();

        return $this->getFactory()->getAttributesMapper()->mapEntityToTransfer($entities);
    }
}
