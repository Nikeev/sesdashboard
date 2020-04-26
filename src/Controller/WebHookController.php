<?php


namespace App\Controller;


use App\Entity\Project;
use App\Repository\EmailRepository;
use App\Utils\WebHookProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebHookController extends BaseController
{
    /**
     * @Route("/webhook/{token}", name="app_webhook")
     */
    public function index(Project $project,
                          Request $request,
                          EntityManagerInterface $em,
                          EmailRepository $emailRepository,
                          WebHookProcessor $processor)
    {

        $jsonData = json_decode($request->getContent(), true);

        if ($jsonData === false) {
            return new Response('Error', Response::HTTP_BAD_REQUEST);
        }

        if ($jsonData['eventType'] == 'Send') {
            $email = $processor->createEmailFromJson($jsonData);
            $email->setProject($project);

            $em->persist($email);
            $emailEvent = $processor->createEmailEventFromJson($email, $jsonData, 'send');
            $em->persist($emailEvent);
        }
        else {
            $email = $emailRepository->findOneBy([
                'project' => $project,
                'messageId' => $jsonData['mail']['messageId'],
            ]);

            if ($jsonData === false) {
                return new Response('Not Found', Response::HTTP_NOT_FOUND);
            }

            try {
                $emailEvent = $processor->createEvent($email, $jsonData);
            } catch (\Exception $e) {
                return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }

            $em->persist($emailEvent);
        }

        $em->flush();

        return new Response('Ok');
    }
}