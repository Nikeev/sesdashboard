<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailRepository")
 */
class Email
{
    const EMAIL_STATUS_SENT = 'sent';
    const EMAIL_STATUS_DELIVERED = 'delivered';
    const EMAIL_STATUS_NOT_DELIVERED = 'not_delivered';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"main", "full"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("full")
     */
    private $messageId;

    /**
     * @ORM\Column(type="json")
     * @Groups({"main", "full"})
     */
    private $destination = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"main", "full"})
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"main", "full"})
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"main", "full"})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"main", "full"})
     */
    private $timestamp;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"main", "full"})
     */
    private $opens = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"main", "full"})
     */
    private $clicks = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmailEvent", mappedBy="email")
     * @ORM\OrderBy({"timestamp" = "DESC"})
     * @Groups("full")
     */
    private $emailEvents;

    public function __construct()
    {
        $this->emailEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function setMessageId(string $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getDestination(): ?array
    {
        return $this->destination;
    }

    public function setDestination(array $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source): self
    {
        $this->source = $source;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getOpens(): ?int
    {
        return $this->opens;
    }

    public function setOpens(int $opens): self
    {
        $this->opens = $opens;

        return $this;
    }

    public function increaseOpens(): self
    {
        $this->opens++;

        return $this;
    }

    public function getClicks(): ?int
    {
        return $this->clicks;
    }

    public function setClicks(int $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function increaseClicks(): self
    {
        $this->clicks++;

        return $this;
    }

    /**
     * @return Collection|EmailEvent[]
     */
    public function getEmailEvents(): Collection
    {
        return $this->emailEvents;
    }

    public function addEmailEvent(EmailEvent $emailEvent): self
    {
        if (!$this->emailEvents->contains($emailEvent)) {
            $this->emailEvents[] = $emailEvent;
            $emailEvent->setEmail($this);
        }

        return $this;
    }

    public function removeEmailEvent(EmailEvent $emailEvent): self
    {
        if ($this->emailEvents->contains($emailEvent)) {
            $this->emailEvents->removeElement($emailEvent);
            // set the owning side to null (unless already changed)
            if ($emailEvent->getEmail() === $this) {
                $emailEvent->setEmail(null);
            }
        }

        return $this;
    }
}
