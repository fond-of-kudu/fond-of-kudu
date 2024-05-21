<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\Mapper;

use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;

class AttributesMapper
{
    /**
     * @var string
     */
    protected const ATTRIBUTES = 'Attributes';

    /**
     * @var string
     */
    protected const ID_PRODUCT_ABSTRACT = 'IdProductAbstract';

    /**
     * @param \Spryker\Service\UtilEncoding\UtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        protected UtilEncodingServiceInterface $utilEncodingService
    ) {
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $entities
     *
     * @return array
     */
    public function mapEntityToTransfer(ObjectCollection $entities): array
    {
        $abstractProductAttributes = [];
        foreach ($entities as $abstractProduct) {
            $abstractProductAttributes[$abstractProduct->getIdProductAbstract()] = $this->utilEncodingService->decodeJson($abstractProduct->getAttributes(), true);
        }

        return $abstractProductAttributes;
    }
}
