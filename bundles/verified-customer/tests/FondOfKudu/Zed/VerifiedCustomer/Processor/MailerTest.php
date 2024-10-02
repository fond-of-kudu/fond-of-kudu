<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Processor;

use Codeception\Test\Unit;
use FondOfKudu\Zed\VerifiedCustomer\Business\Processor\Mailer;
use FondOfKudu\Zed\VerifiedCustomer\Dependency\Facade\VerifiedCustomerToMailInterface;
use FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface;
use FondOfKudu\Zed\VerifiedCustomer\VerifiedCustomerConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class MailerTest extends Unit
{
    /**
     * @var (\FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected VerifiedCustomerRepositoryInterface|MockObject $repositoryMock;

    /**
     * @var (\FondOfKudu\Zed\VerifiedCustomer\Dependency\Facade\VerifiedCustomerToMailInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|VerifiedCustomerToMailInterface $mailFacadeMock;

    /**
     * @var \FondOfKudu\Zed\VerifiedCustomer\Business\Processor\Mailer
     */
    protected Mailer $mailer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->repositoryMock = $this->makeEmpty(VerifiedCustomerRepositoryInterface::class);
        $this->mailFacadeMock = $this->makeEmpty(VerifiedCustomerToMailInterface::class);
        $this->configMock = $this->makeEmpty(VerifiedCustomerConfig::class);
        $this->mailer = new Mailer($this->configMock, $this->repositoryMock, $this->mailFacadeMock);
    }

    /**
     * @return void
     */
    public function testResendAccountVerificationSuccessfullyResendsVerificationEmail(): void
    {
        $customerTransfer = (new CustomerTransfer())->setCustomerReference('test-ref')->setRegistrationKey('test-key');
        $this->repositoryMock->expects($this->once())->method('getCustomerByCustomerReference')->willReturn($customerTransfer);
        $this->mailFacadeMock->expects($this->once())->method('handleMail');

        $response = $this->mailer->resendAccountVerification($customerTransfer);

        $this->assertTrue($response->getSuccess());
    }

    /**
     * @return void
     */
    public function testResendAccountVerificationFailsWhenCustomerReferenceIsMissing(): void
    {
        $customerTransfer = new CustomerTransfer();
        $response = $this->mailer->resendAccountVerification($customerTransfer);

        $this->assertFalse($response->getSuccess());
    }

    /**
     * @return void
     */
    public function testResendAccountVerificationFailsWhenCustomerNotFound(): void
    {
        $customerTransfer = (new CustomerTransfer())->setCustomerReference('test-ref');
        $this->repositoryMock->expects($this->once())->method('getCustomerByCustomerReference')->willReturn(null);

        $response = $this->mailer->resendAccountVerification($customerTransfer);

        $this->assertFalse($response->getSuccess());
    }

    /**
     * @return void
     */
    public function testResendAccountVerificationFailsWhenRegistrationKeyIsMissing(): void
    {
        $customerTransfer = (new CustomerTransfer())->setCustomerReference('test-ref');
        $this->repositoryMock->expects($this->once())->method('getCustomerByCustomerReference')->willReturn($customerTransfer);

        $response = $this->mailer->resendAccountVerification($customerTransfer);

        $this->assertFalse($response->getSuccess());
    }
}
