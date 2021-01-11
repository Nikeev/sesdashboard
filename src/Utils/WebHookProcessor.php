<?php


namespace App\Utils;


use App\Entity\Email;
use App\Entity\EmailEvent;

class WebHookProcessor
{
    public function createEmailFromJson($jsonData): Email
    {
        return (new Email())
            ->setMessageId($jsonData['mail']['messageId'])
            ->setDestination($jsonData['mail']['destination'])
            ->setSource($jsonData['mail']['source'])
            ->setSubject($jsonData['mail']['commonHeaders']['subject'] ?? 'N/A')
            ->setTimestamp(new \DateTime($jsonData['mail']['timestamp']))
            ->setStatus(Email::EMAIL_STATUS_SENT);
    }

    public function createEmailEventFromJson(Email $email, $jsonData, $event): EmailEvent
    {
        $type = self::getEventType($jsonData);

        $emailEvent = (new EmailEvent($email))
            ->setEvent($type)
            ->setEventData($jsonData[$event] ?? []);

        if (!empty($jsonData[$event]['timestamp'])) {
            $emailEvent->setTimestamp(new \DateTime($jsonData[$event]['timestamp']));
        }

        return $emailEvent;
    }

    public function createEvent(Email $email, $jsonData): EmailEvent
    {
        $type = self::getEventType($jsonData);

        switch ($type) {
            case 'Send':
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, 'send');
                break;

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

    /**
     * @param array $jsonData
     * @return mixed
     * @throws \Exception
     */
    public static function getEventType(array $jsonData)
    {
        if (!empty($jsonData['eventType'])) {
            return $jsonData['eventType'];
        }

        else if (!empty($jsonData['notificationType'])) {
            return $jsonData['notificationType'];
        }

        throw new \Exception('Unexpected value');
    }
}