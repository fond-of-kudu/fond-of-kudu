<?php

namespace FondOfKudu\Zed\KlettiesApi\Business;

use FondOfKudu\Zed\KlettiesApi\Business\Model\KlettiesOrderApi;
use FondOfKudu\Zed\KlettiesApi\Business\Model\KlettiesOrderApiInterface;
use FondOfKudu\Zed\KlettiesApi\Business\Model\Validator\KlettiesApiValidator;
use FondOfKudu\Zed\KlettiesApi\Business\Model\Validator\KlettiesApiValidatorInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\KlettiesApiDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface getRepository()()
 */
class KlettiesApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Business\Model\KlettiesOrderApiInterface
     */
    public function createKlettiesApi(): KlettiesOrderApiInterface
    {
        return new KlettiesOrderApi(
            $this->getApiFacade(),
            $this->getKlettiesFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Business\Model\Validator\KlettiesApiValidatorInterface
     */
    public function createKlettiesApiValidator(): KlettiesApiValidatorInterface
    {
        return new KlettiesApiValidator();
    }

    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface
     */
    protected function getApiFacade(): KlettiesApiToApiFacadeInterface
    {
        return $this->getProvidedDependency(KlettiesApiDependencyProvider::FACADE_API);
    }

    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface
     */
    protected function getKlettiesFacade(): KlettiesApiToKlettiesFacadeInterface
    {
        return $this->getProvidedDependency(KlettiesApiDependencyProvider::FACADE_KLETTIES);
    }
}
