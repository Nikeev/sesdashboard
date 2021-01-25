<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailEventRepository")
 */
class EmailEvent
{

    const EVENT_SEND = 'send';
    const EVENT_DELIVERY = 'delivery';
    const EVENT_REJECT = 'reject';
    const EVENT_BOUNCE = 'bounce';
    const EVENT_COMPLAINT = 'complaint';
    const EVENT_FAILURE = 'failure';
    const EVENT_OPEN = 'open';
    const EVENT_CLICK = 'click';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("full")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Email", inversedBy="emailEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("full")
     */
    private $event;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups("full")
     */
    private $eventData = [];

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("full")
     */
    private $timestamp;

    /**
     * EmailEvent constructor.
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = strtolower($event);

        return $this;
    }

    public function getEventData(): ?array
    {
        return $this->eventData;
    }

    public function setEventData(?array $eventData): self
    {
        $this->eventData = $eventData;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(?\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
