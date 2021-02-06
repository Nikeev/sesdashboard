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
        // Some events don't have an event timestamp. Try to extract date from email object.
        else if (!empty($jsonData['mail']['timestamp'])) {
            $emailEvent->setTimestamp(new \DateTime($jsonData['mail']['timestamp']));
        }
        // Use current timestamp otherwise.
        else {
            $emailEvent->setTimestamp(new \DateTime());
        }

        return $emailEvent;
    }

    public function createEvent(Email $email, $jsonData): EmailEvent
    {
        $type = self::getEventType($jsonData);

        switch ($type) {
            case 'Send':
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, EmailEvent::EVENT_SEND);
                break;

            case 'Delivery':
                $email->setStatus(Email::EMAIL_STATUS_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, EmailEvent::EVENT_DELIVERY);
                break;

            case 'Reject':
                $email->setStatus(Email::EMAIL_STATUS_NOT_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, EmailEvent::EVENT_REJECT);
                break;

            case 'Bounce':
                $email->setStatus(Email::EMAIL_STATUS_NOT_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, EmailEvent::EVENT_BOUNCE);
                break;

            case 'Complaint':
                $email->setStatus(Email::EMAIL_STATUS_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, EmailEvent::EVENT_COMPLAINT);
                break;

            case 'Rendering Failure':
                $email->setStatus(Email::EMAIL_STATUS_NOT_DELIVERED);
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, EmailEvent::EVENT_FAILURE);
                break;

            case 'Open':
                $email->increaseOpens();
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, EmailEvent::EVENT_OPEN);
                break;

            case 'Click':
                $email->increaseClicks();
                $emailEvent = $this->createEmailEventFromJson($email, $jsonData, EmailEvent::EVENT_CLICK);
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