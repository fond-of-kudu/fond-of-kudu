<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\Mapper;

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
     * @param array $abstractProductEntities
     *
     * @return array
     */
    public function mapEntityToTransfer(array $abstractProductEntities): array
    {
        $abstractProductAttributes = [];
        foreach ($abstractProductEntities as $abstractProduct) {
            $abstractProductAttributes[$abstractProduct[static::ID_PRODUCT_ABSTRACT]] = $this->utilEncodingService->decodeJson($abstractProduct[static::ATTRIBUTES], true);
        }

        return $abstractProductAttributes;
    }
}
