<?php

namespace SendGridTransportModule;

use Mockery;
use PHPUnit_Framework_TestCase;
use Zend\Mail\Address;
use Zend\Mail\Message;

/**
 * Class SendGridTransportTest
 * @package SendGrid
 */
class SendGridTransportTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function checkIfClassExists()
    {
        $this->assertTrue(class_exists('SendGridTransportModule\SendGridTransport'));
    }

    /**
     * @test
     */
    public function checkSendMethod()
    {
        $mockery = new Mockery();
        $sendGridResponse = $mockery->mock('SendGrid\Response');

        $sendGrid = $mockery->mock('SendGrid');
        $sendGrid->shouldReceive('send')->andReturn($sendGridResponse);

        $email = $mockery->mock('SendGrid\Email');
        $email->shouldReceive('addTo')->andReturn($email);
        $email->shouldReceive('setFrom')->andReturn($email);
        $email->shouldReceive('setSubject')->andReturn($email);
        $email->shouldReceive('setHtml')->andReturn($email);
        $email->shouldReceive('send')->andReturn($sendGridResponse);

        $sendGridTransport = new SendGridTransport($sendGrid, $email);

        $message = new Message();
        $message->addTo(new Address('test@test.com', 'Test'));
        $message->setSubject('Test');
        $message->setFrom(new Address('test@test.com', 'Test'));
        $message->setBody('<p>This is just a test</p>');

        $result = $sendGridTransport->send($message);

        $this->assertTrue($result);
    }
}
