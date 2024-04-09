<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceModel;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceModelInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractHandler;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractHandlerInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductConcreteHandler;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductConcreteHandlerInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportDependencyProvider;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig getConfig()
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface getRepository()
 */
class ProductApiSchedulePriceImportBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceModelInterface
     */
    public function createSalePriceModel(): SalePriceModelInterface
    {
        return new SalePriceModel(
            $this->createSalePriceProductAbstractHandler(),
            $this->createSalePriceProductConcreteHandler(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractHandlerInterface
     */
    protected function createSalePriceProductAbstractHandler(): SalePriceProductAbstractHandlerInterface
    {
        return new SalePriceProductAbstractHandler(
            $this->getPriceProductScheduleFacade(),
            $this->createPriceProductScheduleMapper(),
            $this->getRepository(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductConcreteHandlerInterface
     */
    protected function createSalePriceProductConcreteHandler(): SalePriceProductConcreteHandlerInterface
    {
        return new SalePriceProductConcreteHandler(
            $this->getPriceProductScheduleFacade(),
            $this->createPriceProductScheduleMapper(),
            $this->getRepository(),
            $this->getConfig(),
            $this->getLogger(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected function createPriceProductScheduleMapper(): PriceProductScheduleMapperInterface
    {
        return new PriceProductScheduleMapper(
            $this->getPriceProductFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected function getPriceProductScheduleFacade(): ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
    {
        return $this->getProvidedDependency(ProductApiSchedulePriceImportDependencyProvider::FACADE_PRICE_PRODUCT_SCHEDULE);
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface
     */
    protected function getPriceProductFacade(): ProductApiSchedulePriceImportToPriceProductFacadeInterface
    {
        return $this->getProvidedDependency(ProductApiSchedulePriceImportDependencyProvider::FACADE_PRICE_PRODUCT);
    }
}
