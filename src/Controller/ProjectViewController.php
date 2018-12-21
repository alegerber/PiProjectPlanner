<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Component;
use App\Services\JsonArrayToArrayClasses;

class ProjectViewController extends AbstractController
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var JsonArrayToArrayClasses
     */
    private $jsonArrayToArrayClasses;

    /**
     * @param JsonArrayToArrayClasses
     */
    public function __construct(
        JsonArrayToArrayClasses $jsonArrayToArrayClasses
    ) {
        $this->jsonArrayToArrayClasses = $jsonArrayToArrayClasses;
    }

    /**
     * @Route("/project/{slug}", name="project_view")
     */
    public function index($slug)
    {
        $this->project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findOneBy([
                'link' => $slug,
            ]);

        $categories = $this->jsonArrayToArrayClasses->getArrayClasses(
            $this->project->getCategories(),
            $this->getDoctrine()->getRepository(Category::class)
        );

        $tags = $this->jsonArrayToArrayClasses->getArrayClasses(
            $this->project->getTags(),
            $this->getDoctrine()->getRepository(Tag::class)
        );

        $components = $this->jsonArrayToArrayClasses->getArrayClasses(
            $this->project->getComponents(),
            $this->getDoctrine()->getRepository(Component::class)
        );

        $project = [
            'id' => $this->project->getId(),
            'link' => $this->project->getLink(),
            'title' => $this->project->getTitle(),
            'description' => $this->project->getDescription(),
            'picture' => $this->project->getPicture(),
            'categories' => $categories,
            'tags' => $tags,
            'components' => $components,
        ];

        return $this->render('05-pages/project-view.html.twig', [
            'project' => $project,
        ]);
    }
}
