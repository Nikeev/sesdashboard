<?php


namespace App\Utils;


use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class EmailsCleanupService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Clear emails older than passed date.
     *
     * @param \DateTimeImmutable $date
     * @return bool
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function cleanup(\DateTimeImmutable $date, ?Project $project): bool
    {
        $params = [
            'cleanup' => $date->format('Y-m-d H:i:s'),
        ];

        // Raw query for performance reasons.
        // Delete email events first.
        $sql = "DELETE email_event 
                FROM email_event
                LEFT JOIN email ON email.id = email_event.email_id
                WHERE email.timestamp < :cleanup";
        if ($project) {
            $sql .= ' AND email.project_id = :project';
            $params['project'] = $project->getId();
        }
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute($params);

        // Delete Emails itself.
        $sql = "DELETE FROM email
                WHERE email.timestamp < :cleanup";
        if ($project) {
            $sql .= ' AND email.project_id = :project';
            $params['project'] = $project->getId();
        }
        $stmt = $this->em->getConnection()->prepare($sql);

        return $stmt->execute($params);
    }
}