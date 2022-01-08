<?php

namespace App\Repository;

use App\Entity\Email;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Email|null find($id, $lockMode = null, $lockVersion = null)
 * @method Email|null findOneBy(array $criteria, array $orderBy = null)
 * @method Email[]    findAll()
 * @method Email[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Email::class);
    }


    public function findByProjectQuery(Project $project, $filters = [])
    {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.project = :project')
            ->setParameter('project', $project)
            ->orderBy('e.timestamp', 'DESC')
        ;

        if (!empty($filters['search'])) {
            $qb
                ->andWhere('e.destination LIKE :search OR e.subject LIKE :search')
                ->setParameter('search', '%' . addcslashes($filters['search'], '%_') . '%');
        }

        if (!empty($filters['dateFrom'])) {
            $qb
                ->andWhere('e.timestamp >= :dateFrom')
                ->setParameter('dateFrom', $filters['dateFrom']);
        }

        if (!empty($filters['dateTo'])) {
            $qb
                ->andWhere('e.timestamp <= :dateTo')
                ->setParameter('dateTo', $filters['dateTo']);
        }

        if (!empty($filters['eventType'])) {
            $qb
                ->distinct()
                ->leftJoin('e.emailEvents', 'ee')
                ->andWhere('ee.event = :eventType')
                ->setParameter('eventType', $filters['eventType']);
        }

        return $qb->getQuery();
    }

}
