<?php

namespace FondOfKudu\Zed\KlettiesApi\Business\Model\Validator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiRequestTransfer;

class KlettiesApiValidatorTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\ApiRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiRequestTransferMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\Model\Validator\KlettiesApiValidatorInterface
     */
    protected $validator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validator = new KlettiesApiValidator();
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->assertSame([], $this->validator->validate($this->apiRequestTransferMock));
    }
}
