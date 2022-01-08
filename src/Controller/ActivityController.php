<?php

namespace App\Controller;

use App\Entity\Email;
use App\Repository\EmailRepository;
use App\Repository\ProjectRepository;
use App\Utils\ActivityExport\Report;
use App\Utils\ActivityExport\WriterFormatFactory;
use App\Utils\ActivitySearchFilters;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ActivityController extends AbstractController
{
    /**
     * @Route("/activity", name="app_activity")
     */
    public function index(ProjectRepository $projectRepository)
    {

        $project = $projectRepository->findOneBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('activity/index.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/activity/list/api", name="app_activity_list_api")
     */
    public function listApi(Request $request,
                            EmailRepository $emailRepository,
                            ProjectRepository $projectRepository,
                            PaginatorInterface $paginator,
                            SerializerInterface $serializer,
                            ActivitySearchFilters $activitySearchFilters)
    {
        $project = $projectRepository->findOneBy([
            'user' => $this->getUser(),
        ]);

        if (!$project) {
            return $this->json([
                'error' => 'No project found',
            ]);
        }

        try {
            $filters = $activitySearchFilters->getFiltersFromRequest($request);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        $pagination = $paginator->paginate(
            $emailRepository->findByProjectQuery($project, $filters),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        $rows = $pagination->getItems();

        return $this->json([
            'rows' => $serializer->normalize($rows, 'array', ['groups' => 'main']),
            'totalRows' => $pagination->getTotalItemCount(),
        ]);
    }

    /**
     * @Route("/activity/details/api", name="app_activity_details_api")
     */
    public function detailsApi(Request $request, EmailRepository $emailRepository, SerializerInterface $serializer)
    {
        // TODO Permissions
        $email = $emailRepository->find($request->get('id'));
        return $this->json($serializer->normalize($email, 'array', ['groups' => 'full']));
    }

    /**
     * @Route("/activity/export", name="app_activity_export")
     */
    public function export(Request $request,
                           Report $report,
                           ProjectRepository $projectRepository,
                           ActivitySearchFilters $activitySearchFilters,
                           WriterFormatFactory $writerFormatFactory): Response
    {
        $project = $projectRepository->findOneBy([
            'user' => $this->getUser(),
        ]);

        if (!$project) {
            throw $this->createNotFoundException();
        }

        try {
            $filters = $activitySearchFilters->getFiltersFromRequest($request);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        $report = $report->report($project, $filters);

        try {
            $writer = $writerFormatFactory->get($request->get('format'));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $response = new StreamedResponse(static function () use ($writer, $report): void {
            $writer->openToFile('php://output');

            $writer->addRow(WriterEntityFactory::createRowFromArray([
                'Status',
                'Subject',
                'Destination',
                'Date UTC',
                'Opens',
                'Clicks',
            ]));

            foreach ($report as $row) {
                $writer->addRow(WriterEntityFactory::createRowFromArray($row));
            }

            $writer->close();
        });

        // TODO Refactor
        if ($request->get('format') == 'csv') {
            $disposition = HeaderUtils::makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'activity_report.csv');
            $response->headers->set('Content-Type', 'text/csv');
        }
        else {
            $disposition = HeaderUtils::makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'activity_report.xlsx');
            $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
