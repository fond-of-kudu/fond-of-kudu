<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientBridge;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientBridge;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceBridge;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class DiscountPromotionsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_PRODUCT_RESOURCE_ALIAS = 'CLIENT_PRODUCT_RESOURCE_ALIAS';

    /**
     * @var string
     */
    public const CLIENT_PRICE_PRODUCT_STORAGE = 'CLIENT_PRICE_PRODUCT_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_PRODUCT_STORAGE = 'CLIENT_PRODUCT_STORAGE';

    /**
     * @var string
     */
    public const SERVICE_DISCOUNT = 'SERVICE_DISCOUNT';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addProductResourceAliasStorageClient($container);
        $container = $this->addProductStorageClient($container);
        $container = $this->addDiscountService($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addProductResourceAliasStorageClient(Container $container): Container
    {
        $container[static::CLIENT_PRODUCT_RESOURCE_ALIAS] = static fn (
            Container $container
        ): DiscountPromotionRestApiToProductResourceAliasStorageClientInterface => new DiscountPromotionRestApiToProductResourceAliasStorageClientBridge(
            $container->getLocator()->productResourceAliasStorage()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addProductStorageClient(Container $container): Container
    {
        $container[static::CLIENT_PRODUCT_STORAGE] = static fn (
            Container $container
        ): DiscountPromotionsRestApiToProductStorageClientInterface => new DiscountPromotionsRestApiToProductStorageClientBridge(
            $container->getLocator()->productStorage()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addDiscountService(Container $container): Container
    {
        $container[static::SERVICE_DISCOUNT] = static fn (
            Container $container
        ): DiscountPromotionsRestApiToDiscountServiceInterface => new DiscountPromotionsRestApiToDiscountServiceBridge(
            $container->getLocator()->discount()->service(),
        );

        return $container;
    }
}
