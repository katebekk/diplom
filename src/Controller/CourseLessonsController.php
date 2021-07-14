<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher")
 */
class CourseLessonsController extends AbstractController
{
    private $courseRepository;

    public function __construct(
        CourseRepository $courseRepository){
        $this->courseRepository = $courseRepository;

    }
    /**
     * @Route("/course/lessons/{courseId}", name="course_lessons")
     */
    public function index( $courseId): Response
    {
        $course = $this->courseRepository->findOneBy(['id'=>$courseId]);

        return $this->render('course_lessons/index.html.twig', [
            'course'=>$course,
        ]);
    }
}
