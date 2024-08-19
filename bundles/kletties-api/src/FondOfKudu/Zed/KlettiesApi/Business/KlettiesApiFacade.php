<?php

namespace FondOfKudu\Zed\KlettiesApi\Business;

use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * Class KlettiesApiFacade
 *
 * @package FondOfKudu\Zed\KlettiesApi\Business
 *
 * @method \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiBusinessFactory getFactory()
 * @method \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface getRepository()
 */
class KlettiesApiFacade extends AbstractFacade implements KlettiesApiFacadeInterface
{
    /**
     * @param int $idKlettiesOrder
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function updateKlettiesOrder(int $idKlettiesOrder, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFactory()->createKlettiesApi()->update($idKlettiesOrder, $apiDataTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function findKlettiesOrder(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        return $this->getFactory()->createKlettiesApi()->find($apiRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array
    {
        return $this->getFactory()->createKlettiesApiValidator()->validate($apiRequestTransfer);
    }
}
