<?php

namespace FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface CustomerMergeGuestOrderToZedRequestClientInterface
{
    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param array|int|null $requestOptions Deprecated: Do not use "int" anymore, please use an array for requestOptions.
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call($url, TransferInterface $object, $requestOptions = null);
}
