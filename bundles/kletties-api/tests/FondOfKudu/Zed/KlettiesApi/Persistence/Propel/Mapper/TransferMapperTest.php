<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer;

class TransferMapperTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapperInterface
     */
    protected TransferMapperInterface $mapper;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->mapper = new TransferMapper();
    }

    /**
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertInstanceOf(
            FokKlettiesOrderEntityTransfer::class,
            $this->mapper->toTransfer([]),
        );
    }

    /**
     * @return void
     */
    public function testToTransferCollection(): void
    {
        $mapped = $this->mapper->toTransferCollection([[]]);
        $this->assertIsArray($mapped);
        $this->assertCount(1, $mapped);
        $this->assertInstanceOf(
            FokKlettiesOrderEntityTransfer::class,
            $mapped[0],
        );
    }
}
