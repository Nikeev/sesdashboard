<?php

namespace App\Tests;

use App\Entity\Email;
use App\Entity\EmailEvent;
use App\Utils\WebHookProcessor;
use PHPUnit\Framework\TestCase;

class WebHookProcessorTest extends TestCase
{
    public function testCreateEmail()
    {
        $webHookProcessor = new WebHookProcessor();

        $date = new \DateTime();

        $email = $webHookProcessor->createEmailFromJson(
            [
                'mail' => [
                    'messageId' => '1a',
                    'destination' => ['test@test.com'],
                    'source' => 'site@site.com',
                    'timestamp' => $date->format('Y-m-d\TH:i:s.u\Z'),
                    'commonHeaders' => [
                        'subject' => 'Test',
                    ],
                ],
            ]
        );

        $this->assertSame($email->getMessageId(), '1a', 'Message ID is incorrect');
        $this->assertSame($email->getDestination(), ['test@test.com'], 'Email Destination is incorrect');
        $this->assertSame($email->getSource(), 'site@site.com', 'Email source is incorrect');
        $this->assertEquals($email->getSubject(), 'Test', 'Email subject is incorrect');
        $this->assertEquals($email->getTimestamp(), $date, 'Email dates parsed wrong');
        $this->assertSame($email->getStatus(), Email::EMAIL_STATUS_SENT, 'Email status should be Sent');
    }

    public function testEventTypeGetter()
    {
        $type = WebHookProcessor::getEventType([
            'eventType' => 'Send'
        ]);
        $this->assertEquals($type, 'Send');

        $type = WebHookProcessor::getEventType([
            'notificationType' => 'Send'
        ]);
        $this->assertEquals($type, 'Send');


        $this->expectException(\Exception::class);
        WebHookProcessor::getEventType([
            'oops' => 'Send'
        ]);
    }

    public function testCreateEvent()
    {
        $email = new Email();

        $webHookProcessor = new WebHookProcessor();

        $date = new \DateTime();

        $emailEvent = $webHookProcessor->createEvent($email, [
            'eventType' => 'Send',
            'send' => [
                'timestamp' => $date->format('Y-m-d\TH:i:s.u\Z'),
            ]
        ]);

        $this->assertEquals(EmailEvent::EVENT_SEND, $emailEvent->getEvent(), 'Event type is wrong');
        $this->assertEquals($emailEvent->getTimestamp(), $date, 'Email event date parsed wrong');
    }
}
