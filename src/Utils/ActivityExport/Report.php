<?php

namespace App\Utils\ActivityExport;

use App\Entity\Email;
use App\Entity\Project;
use App\Repository\EmailRepository;
use Doctrine\ORM\EntityManagerInterface;

class Report
{

    /**
     * @var EmailRepository
     */
    private $emailRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EmailRepository $emailRepository, EntityManagerInterface $em)
    {
        $this->emailRepository = $emailRepository;
        $this->em = $em;
    }

    public function report(Project $project, array $filters): \Generator
    {
        $emailsQ = $this->emailRepository->findByProjectQuery($project, $filters);

        /** @var Email $email */
        foreach ($emailsQ->toIterable() as $email) {
            $row = [
                $email->getStatus(),
                $email->getSubject(),
                implode(', ', $email->getDestination()),
                $email->getTimestamp()->format('m/d/Y H:i'),
                $email->getOpens(),
                $email->getClicks(),
            ];
            $this->em->detach($email);
            yield $row;
        }
    }
}