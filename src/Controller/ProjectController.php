<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Entity\Image;
use App\Entity\Tag;
use App\Form\ProjectType;
use App\Services\UploadedFileFormHandling;
use App\Services\CheckExistInArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Query\ResultSetMapping;

class ProjectController extends AbstractController
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var UploadedFileFormHandling
     */
    private $uploadedFileFormHandling;

    /**
     * @var CheckExistInArrayCollection
     */
    private $checkExistInArrayCollection;

    public function __construct(
        UploadedFileFormHandling $uploadedFileFormHandling,
        CheckExistInArrayCollection $checkExistInArrayCollection
    ) {
        $this->uploadedFileFormHandling = $uploadedFileFormHandling;
        $this->checkExistInArrayCollection = $checkExistInArrayCollection;
    }

    /**
     * @Route("/project", methods={"GET"}, name="project")
     */
    public function index()
    {
        /**
         * @var Project[]
         */
        $projects = $this->getDoctrine()
        ->getRepository(Project::class)->findAll();

        return $this->render('05-pages/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/project/new", methods={"GET", "POST"}, name="project_new")
     */
    public function new(Request $request)
    {
        $project = new Project();

        $image = new Image();
        $image->setUploadedFile(new UploadedFile('img/placeholder.jpg', 'placeholder.jpg'));

        $project->setImage($image);

        $form = $this->createForm(ProjectType::class, $project);

        $oldFileName = $project->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getImage()->getUploadedFile()->getFilename() !=
            $oldFileName
            ) {
                $this->uploadedFileFormHandling->handle(
                    $form->getData()->getImage(),
                    $this->getParameter('image_file_directory')
                );
            }

            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($image);
            $entityManger->persist($project);
            $entityManger->flush();

            return $this->redirectToRoute('project_edit', [
                'slug' => $project->getSlug(),
            ]);
        }

        return $this->render('05-pages/project-new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/{slug}", methods={"GET", "POST"}, name="project_edit")
     */
    public function edit(Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);

        $oldFileName = $project->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getImage()->getUploadedFile()->getFilename() !=
            $oldFileName
            ) {
                $this->uploadedFileFormHandling->handle(
                    $form->getData()->getImage(),
                    $this->getParameter('image_file_directory')
                );
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_edit', [
                'slug' => $project->getSlug(),
            ]);
        }

        return $this->render('05-pages/project-view.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/{slug}/delete", methods={"POST"}, name="project_delete")
     */
    public function delete(Request $request, Project $project)
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('project');
        }

        $entityManger = $this->getDoctrine()->getManager();

        $image = $project->getImage();
        $entityManger->remove($project);
        $entityManger->remove($image);
        $entityManger->flush();

        return $this->redirectToRoute('project');
    }
}
