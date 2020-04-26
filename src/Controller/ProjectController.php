<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Utils\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends BaseController
{
    /**
     * @Route("/project", name="app_project_list")
     */
    public function list(ProjectRepository $projectRepository)
    {
        $projects = $projectRepository->findBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('project/list.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/project/add", name="app_project_add")
     */
    public function add(Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em)
    {
        $projects = $projectRepository->findBy([
            'user' => $this->getUser(),
        ]);

        // TODO Multiple projects.
        if ($projects) {
            return new \LogicException('Only one project available yet.');
        }

        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUser($this->getUser());
            $project->setToken(TokenGenerator::generate());

            $em->persist($project);
            $em->flush();

            $this->addFlash('success', 'New project created! Now you can configure your AWS account to use webhook.');

            return $this->redirectToRoute('app_project_edit', ['id' => $project->getId()]);
        }


        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("/project/{id}/edit", name="app_project_edit")
     */
    public function edit(Request $request, Project $project, EntityManagerInterface $em)
    {

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($project);
            $em->flush();


            $this->addFlash('success', 'Project updated!');

            return $this->redirectToRoute('app_project_edit', ['id' => $project->getId()]);
        }


        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }
}
