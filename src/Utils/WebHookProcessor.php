<?php


namespace App\Utils;


use App\Entity\Email;
use App\Entity\EmailEvent;

class WebHookProcessor
{
    public function createEmailFromJson($jsonData)
    {
        return (new Email())
            ->setMessageId($jsonData['mail']['messageId'])
            ->setDestination($jsonData['mail']['destination'])
            ->setSource($jsonData['mail']['source'])
            ->setSubject($jsonData['mail']['commonHeaders']['subject'])
            ->setTimestamp(new \DateTime($jsonData['mail']['timestamp']))
            ->setStatus(Email::EMAIL_STATUS_SENT);
    }

    public function createEmailEventFromJson(Email $email, $jsonData, $event)
    {
        $emailEvent = (new EmailEvent($email))
            ->setEvent($jsonData['eventType'])
            ->setEventData($jsonData[$event]);

        if (!empty($jsonData[$event]['timestamp'])) {
            $emailEvent->setTimestamp(new \DateTime($jsonData[$event]['timestamp']));
        }

        return $emailEvent;
    }

    public function createEvent(Email $email, $jsonData)
    {
        switch ($jsonData['eventType']) {
            case 'Delivery':
                $email->setStatus(Email::EMAIL_STATUS_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, 'delivery');
                break;

            case 'Reject':
                $email->setStatus(Email::EMAIL_STATUS_NOT_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, 'reject');
                break;

            case 'Bounce':
                $email->setStatus(Email::EMAIL_STATUS_NOT_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, 'bounce');
                break;

            case 'Complaint':
                $email->setStatus(Email::EMAIL_STATUS_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, 'complaint');
                break;

            case 'Rendering Failure':
                $email->setStatus(Email::EMAIL_STATUS_NOT_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, 'failure');
                break;

            case 'Open':
                $email->increaseOpens();
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, 'open');
                break;

            case 'Click':
                $email->increaseClicks();
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, 'click');
                break;

            default:
                throw new \Exception('Unexpected value');
        }

        return $emailEvent;
    }
}