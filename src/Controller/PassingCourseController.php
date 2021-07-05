<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Passing;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CourseRepository;
use App\Repository\PassingRepository;

class PassingCourseController extends AbstractController
{
    private $courseRepository;
    private $passingRepository;

    public function __construct(
        CourseRepository $courseRepository,
        PassingRepository $passingRepository
    )
    {
        $this->courseRepository = $courseRepository;
        $this->passingRepository = $passingRepository;

    }

    /**
     * @Route("/learner/passing/show_course/{courseId}", name="show_course", methods={"GET"})
     */
    public function show_course(Request $request, $courseId): Response
    {
        $course = $this->courseRepository->findOneBy(['id'=>$courseId]);
        if ($request->request->has('newLesson')) {
            $lessonName = $request->request->get('lessonName');
            $lesson = new Lesson();
            $lesson->setName($lessonName);
            $lesson->setCourse($course);
            $course->addLesson($lesson);
        }
        return $this->render('passing_course/show.html.twig', [
            'course' => $course
        ]);
    }

    /**
     * @Route("/learner/my_courses_learner", name="my_courses_learner", methods={"GET"})
     */
    public function my_courses_learner(Request $request): Response
    {
        $curUser = $this->getUser();
        return $this->render('passing_course/my_courses_learner.html.twig', [
            'courses' => $curUser->getCoursePassed(),
        ]);
    }

    /**
     * @Route("/learner/passing/show_course/enroll/{courseId}", name="enroll_course", methods={"POST"})
     */
    public function enroll_course(Request $request, $courseId): Response
    {
        $curUser = $this->getUser();
        $course = $this->courseRepository->findOneBy(['id'=>$courseId]);
        if ($this->isCsrfTokenValid('enroll'.$course->getId(), $request->request->get('_token'))) {
            $curUser->addCoursePassed($course);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_course', ['courseId'=>$courseId]);
    }

    /**
     * @Route("/learner/passing/show_course/deduct/{courseId}", name="deduct_course", methods={"POST"})
     */
    public function deduct_course(Request $request, $courseId): Response
    {
        $curUser = $this->getUser();
        $course = $this->courseRepository->findOneBy(['id'=>$courseId]);
        if ($this->isCsrfTokenValid('deduct'.$course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $curUser->removeCoursePassed($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_course', ['courseId'=>$courseId]);
    }

    /**
     * @Route("/learner/passing/pass_course/{courseId}", name="passing", methods={"GET"})
     */
    public function passing(Request $request, $courseId): Response
    {
        $course = $this->courseRepository->findOneBy(['id'=>$courseId]);
        $curUser = $this->getUser();
        if($curUser->isPassing($course) == false){
            $passing = new Passing();
            $passing->setCourse($course);
            $passing->setUser($curUser);

            $curUser->addPassing($passing);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->render('passing_course/passing.html.twig', [
            'course' => $course
        ]);
    }
}
