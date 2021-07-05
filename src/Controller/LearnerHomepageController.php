<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CourseRepository;

class LearnerHomepageController extends AbstractController
{
    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    /**
     * @Route("/learner/homepage", name="learner_homepage")
     */
    public function index(): Response
    {
        return $this->render('learner_homepage/index.html.twig', [
            'courses' => $this->courseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/learner/grouped_by_difficulty/{difficultyLevel}", name="grouped_by_difficulty")
     */
    public function grouped_by_difficulty(String $difficultyLevel): Response
    {
        $courses = $this->courseRepository->findBy(['difficultyLevel'=>$difficultyLevel]);
        return $this->render('learner_homepage/grouped_by_difficulty.html.twig', [
            'courses' => $courses,
            'difficultyLevel'=>$difficultyLevel
        ]);
    }
}
