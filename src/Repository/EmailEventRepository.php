<?php

namespace App\Repository;

use App\Entity\EmailEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmailEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailEvent[]    findAll()
 * @method EmailEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailEvent::class);
    }

    public function countEmailEventsByDateRange(\DateTimeImmutable $dateFrom, \DateTimeImmutable $dateTo)
    {
        return $this->createQueryBuilder('e')
            ->select('e.event, COUNT(e.id) as count')
            ->where("e.timestamp >= :dateFrom AND e.timestamp <= :dateTo")
            ->setParameters([
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ])
            ->groupBy('e.event')
            ->getQuery()
            ->getResult();
    }

    public function countDailyEmailEventsByDateRange(\DateTimeImmutable $dateFrom, \DateTimeImmutable $dateTo, $tzOffset = '+00:00')
    {
        return $this->createQueryBuilder('e')
            ->select("e.event, COUNT(e.id) as count, DATE_FORMAT(CONVERT_TZ(e.timestamp, '+00:00', :tzOffset), '%Y-%m-%d') as daygroup")
            ->where("e.timestamp >= :dateFrom AND e.timestamp <= :dateTo")
            ->setParameters([
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'tzOffset' => $tzOffset,
            ])
            ->groupBy("daygroup")
            ->addGroupBy('e.event')
            ->orderBy('daygroup', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
