<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
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
            $this->addFlash('info', 'No project created.');
        }

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
