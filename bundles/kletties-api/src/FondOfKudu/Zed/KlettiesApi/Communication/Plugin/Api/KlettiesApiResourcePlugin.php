<?php

namespace FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api;

use FondOfKudu\Shared\KlettiesApi\KlettiesApiConstants;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Api\Business\Exception\ApiDispatchingException;
use Spryker\Zed\Api\Dependency\Plugin\ApiResourcePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiBusinessFactory getFactory()
 */
class KlettiesApiResourcePlugin extends AbstractPlugin implements ApiResourcePluginInterface
{
    /**
     * @param int $idKlettiesOrder
     *
     * @throws \Spryker\Zed\Api\Business\Exception\ApiDispatchingException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get($idKlettiesOrder): ApiItemTransfer
    {
        throw new ApiDispatchingException('Get method is not implemented yet.', ApiConfig::HTTP_CODE_NOT_FOUND);
    }

    /**
     * @param int $idKlettiesOrder
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($idKlettiesOrder, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFacade()->updateKlettiesOrder($idKlettiesOrder, $apiDataTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\ApiDispatchingException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function add(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        throw new ApiDispatchingException('Add method is not implemented yet.', ApiConfig::HTTP_CODE_NOT_FOUND);
    }

    /**
     * @param int $idKlettiesOrder
     *
     * @throws \Spryker\Zed\Api\Business\Exception\ApiDispatchingException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function remove($idKlettiesOrder): ApiItemTransfer
    {
        throw new ApiDispatchingException('Remove method not implemented on core level', ApiConfig::HTTP_CODE_NOT_FOUND);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        return $this->getFacade()->findKlettiesOrder($apiRequestTransfer);
    }

    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return KlettiesApiConstants::RESOURCE_KLETTIES_ORDERS_API;
    }
}
