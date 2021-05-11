<?php

namespace App\Controller;

use App\Entity\EmailEvent;
use App\Repository\EmailEventRepository;
use App\Repository\ProjectRepository;
use App\Utils\DashboardStatsHelper;
use DoctrineExtensions\Query\Mysql\Date;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseController
{
    /**
     * @Route("/", name="app_dashboard")
     */
    public function index(ProjectRepository $projectRepository)
    {
        $project = $projectRepository->findOneBy([
            'user' => $this->getUser(),
        ]);

        if (!$project) {
            $this->addFlash('info', 'No project created yet');
        }

        return $this->render('dashboard/index.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/dashboard/api", name="app_dashboard_api")
     */
    public function jsApi(Request $request,
                          ProjectRepository $projectRepository,
                          DashboardStatsHelper $dashboardStatsHelper)
    {
        $project = $projectRepository->findOneBy([
            'id' => (int) $request->get('projectId'),
            'user' => $this->getUser(),
        ]);

        if (!$project) {
            return $this->json(['error' => 'No project found!'], Response::HTTP_NOT_FOUND);
        }

        try {
            $dateFrom = new \DateTimeImmutable($request->get('dateFrom'));
            $dateTo = new \DateTimeImmutable($request->get('dateTo'));
        } catch (\Exception $e) {
            return $this->json(['error' => 'Wrong range date!'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'counters' => $dashboardStatsHelper->getCounters($dateFrom, $dateTo),
            'chartData' => $dashboardStatsHelper->getChartData($dateFrom, $dateTo, $request->get('tzOffset')),
        ]);
    }
}
