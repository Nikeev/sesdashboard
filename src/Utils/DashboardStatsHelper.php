<?php


namespace App\Utils;


use App\Entity\EmailEvent;
use App\Repository\EmailEventRepository;

class DashboardStatsHelper
{
    /**
     * @var EmailEventRepository
     */
    private $repository;

    public function __construct(EmailEventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return array of counters by Event types.
     * Not delivered events are grouped.
     *
     * @param \DateTimeImmutable $dateFrom
     * @param \DateTimeImmutable $dateTo
     * @return array|int[]
     */
    public function getCounters(\DateTimeImmutable $dateFrom, \DateTimeImmutable $dateTo): array
    {
        $eventsCount = $this->repository->countEmailEventsByDateRange($dateFrom, $dateTo);

        $counters = [];

        foreach ($eventsCount as $counter) {
            $counters[$counter['event']] = $counter['count'];
        }

        $notDelivered = ($counters[EmailEvent::EVENT_FAILURE] ?? 0)
            + ($counters[EmailEvent::EVENT_COMPLAINT] ?? 0)
            + ($counters[EmailEvent::EVENT_BOUNCE] ?? 0)
            + ($counters[EmailEvent::EVENT_REJECT] ?? 0);

        return [
            'sent' => $counters[EmailEvent::EVENT_SEND] ?? 0,
            'delivered' => $counters[EmailEvent::EVENT_DELIVERY] ?? 0,
            'opens' => $counters[EmailEvent::EVENT_OPEN] ?? 0,
            'clicks' => $counters[EmailEvent::EVENT_CLICK] ?? 0,
            'notDelivered' => $notDelivered,
        ];
    }

    /**
     * Return events count grouped by date formatted for ChartJs
     *
     * @param \DateTimeImmutable $dateFrom
     * @param \DateTimeImmutable $dateTo
     * @return array
     */
    public function getChartData(\DateTimeImmutable $dateFrom, \DateTimeImmutable $dateTo, string $tzOffset): array
    {
        $countersByDate = $this->repository->countDailyEmailEventsByDateRange($dateFrom, $dateTo, TimezoneOffsetFormatter::format($tzOffset));

        $labels = [];
        $datasets = [];
        foreach ($countersByDate as $counter) {
            $labels[$counter['daygroup']] = $counter['daygroup'];

            if (empty($datasets[$counter['event']])) {
                $datasets[$counter['event']] = [
                    'label' => ucfirst($counter['event']),
                    'data' => [],
                ];
            }

            $datasets[$counter['event']]['data'][] = $counter['count'];
        }

        return [
            'labels' => array_values($labels),
            'datasets' => array_values($datasets),
        ];
    }
}