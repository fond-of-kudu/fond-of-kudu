<?php

namespace FondOfKudu\Zed\KlettiesApi\Business\Model;

use Exception;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Api\Business\Exception\EntityNotSavedException;

class KlettiesOrderApi implements KlettiesOrderApiInterface
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface
     */
    protected KlettiesApiToApiFacadeInterface $apiFacade;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface
     */
    protected KlettiesApiToKlettiesFacadeInterface $klettiesFacade;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface
     */
    protected KlettiesApiRepositoryInterface $repository;

    /**
     * @param \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface $apiFacade
     * @param \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface $klettiesFacade
     * @param \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface $repository
     */
    public function __construct(
        KlettiesApiToApiFacadeInterface $apiFacade,
        KlettiesApiToKlettiesFacadeInterface $klettiesFacade,
        KlettiesApiRepositoryInterface $repository
    ) {
        $this->apiFacade = $apiFacade;
        $this->klettiesFacade = $klettiesFacade;
        $this->repository = $repository;
    }

    /**
     * @param int $idKlettiesOrder
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotSavedException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update(int $idKlettiesOrder, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $klettiesOrderTransfer = $this->createKlettiesOrderTransfer($apiDataTransfer->getData());

        try {
            $klettiesOrderTransfer = $this->klettiesFacade->updateKlettiesOrder($klettiesOrderTransfer);
        } catch (Exception $exception) {
            throw new EntityNotSavedException(
                sprintf('Could not update kletties order with id %s', $idKlettiesOrder),
                ApiConfig::HTTP_CODE_INTERNAL_ERROR,
                $exception,
            );
        }

        return $this->apiFacade->createApiItem(
            $klettiesOrderTransfer,
            (string)$klettiesOrderTransfer->getId(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        return $this->repository->find($apiRequestTransfer);
    }

    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    protected function createKlettiesOrderTransfer(array $data): KlettiesOrderTransfer
    {
        return (new KlettiesOrderTransfer())->fromArray($data, true);
    }
}
