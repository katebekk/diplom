<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Passing;
use App\Entity\DrawingCheckResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CourseRepository;
use App\Repository\PassingRepository;
use App\Repository\LessonStageRepository;
use App\Repository\DrawingCheckResultRepository;
use App\Utils\Service\CheckDrawingService;

class PassingCourseController extends AbstractController
{
    private $courseRepository;
    private $passingRepository;
    private $lessonStageRepository;
    private $drawingCheckResultRepository;
    private $checkDrawingService;

    public function __construct(
        CourseRepository $courseRepository,
        PassingRepository $passingRepository,
        LessonStageRepository $lessonStageRepository,
        DrawingCheckResultRepository $drawingCheckResultRepository,
        CheckDrawingService $checkDrawingService
    )
    {
        $this->courseRepository = $courseRepository;
        $this->passingRepository = $passingRepository;
        $this->lessonStageRepository = $lessonStageRepository;
        $this->drawingCheckResultRepository = $drawingCheckResultRepository;
        $this->checkDrawingService = $checkDrawingService;
    }

    /**
     * @Route("/learner/passing/show_course/{courseId}", name="show_course", methods={"GET"})
     */
    public function show_course(Request $request, $courseId): Response
    {
        $course = $this->courseRepository->findOneBy(['id' => $courseId]);
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
        $course = $this->courseRepository->findOneBy(['id' => $courseId]);
        if ($this->isCsrfTokenValid('enroll' . $course->getId(), $request->request->get('_token'))) {
            $curUser->addCoursePassed($course);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_course', ['courseId' => $courseId]);
    }

    /**
     * @Route("/learner/passing/show_course/deduct/{courseId}", name="deduct_course", methods={"POST"})
     */
    public function deduct_course(Request $request, $courseId): Response
    {
        $curUser = $this->getUser();
        $course = $this->courseRepository->findOneBy(['id' => $courseId]);
        if ($this->isCsrfTokenValid('deduct' . $course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $passing = $curUser->getCurPassing($course);
            if($passing!=null){
                $curUser->removePassing($passing);
                $entityManager->remove($passing);
            }
            $curUser->removeCoursePassed($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_course', [
            'courseId' => $courseId]);
    }

    /**
     * @Route("/learner/passing/pass_course/{courseId}/{curLesson}/{curStage}", name="passing", methods={"GET","POST"})
     */
    public function passing(Request $request, $courseId, int $curLesson, int $curStage): Response
    {
        $course = $this->courseRepository->findOneBy(['id' => $courseId]);
        $curUser = $this->getUser();
        $passing = $this->passingRepository->findOneBy(['course' => $course, 'user' => $curUser]);

        if ($passing == null) {
            $passing = new Passing();
            $passing->setCourse($course);
            $passing->setUser($curUser);
            $passing->setIsComplited(false);

            $curUser->addPassing($passing);

            $entityManager = $this->getDoctrine()->getManager();
            $passing->setCourse($course);
            $entityManager->persist($passing);
            $entityManager->flush();

            return $this->render('passing_course/passing.html.twig', [
                'passing' => $passing,
                'course' => $course,
                'curLesson' => $passing->getCurLesson(),
                'curStage' => $passing->getCurStage()
            ]);

        } elseif ($curLesson != 0 or $curStage != 0) {
            $passing->setCurLesson($curLesson);
            $passing->setCurStage($curStage);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        $result = $passing->isDrawingCheckResult($course->getLessons()[$passing->getCurLesson()]->getLessonStages()[$passing->getCurStage()]);
        if($result!= null){
            return $this->render('passing_course/passing.html.twig', [
                'passing' => $passing,
                'course' => $course,
                'curLesson' => $passing->getCurLesson(),
                'curStage' => $passing->getCurStage(),
                'result'=>$result
            ]);
        }
        return $this->render('passing_course/passing.html.twig', [
            'passing' => $passing,
            'course' => $course,
            'curLesson' => $passing->getCurLesson(),
            'curStage' => $passing->getCurStage()
        ]);
    }

    /**
     * @Route("/learner/passing/pass_course/{courseId}/{curLesson}/{curStage}/check_drawing/{passingId}/{stageId}}", name="check_drawing", methods={"GET","POST"})
     */
    public function check_drawing(Request $request, $courseId, int $curLesson, int $curStage, $stageId, $passingId): Response
    {
        $curUser = $this->getUser();
        $stage = $this->lessonStageRepository->findOneBy(["id" => $stageId]);
        $passing = $this->passingRepository->findOneBy(['id' => $passingId]);
        if ($request->request->has('submit')) {
            if ($passing->isDrawingCheckResult($stage)!=null) {
                $result = $passing->isDrawingCheckResult($stage);
                $passing->removeResult($result);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($result);
                $entityManager->flush();
            }
            $result = new DrawingCheckResult();
            $file = $request->files->get('image');

            $uploads_reference_directory = $this->getParameter('uploads_image_example_stage');
            $uploads_learners_directory = $this->getParameter('uploads_image_learners');
            $uploadfile = md5(uniqid()) . '_' . basename($_FILES['image']['name']);

            $file->move(
                $uploads_learners_directory,
                $uploadfile
            );
            $referenceImg = $uploads_reference_directory . "/" . $stage->getExampleImageStage();
            $learnersImg = $uploads_learners_directory . "/" . $uploadfile;

            $command = "python3 /var/www/diplom/python/main.py $referenceImg $learnersImg";
            $output = null;
            $status = null;
            $result->setUser($curUser);
            $result->setLessonStage($stage);
            $result->setPassing($passing);

            exec($command, $output, $status);
            if ($status == 0) {
                $resultArray = json_decode($output[0], true);
                $result->setResultImage($resultArray["img"]);
                $result->setResultMessage($resultArray["message"]);
                $result->setPercent(intval($resultArray["percent"]));

                $passing->addResult($result);


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($result);
                $entityManager->flush();
            }

            if($status==1){
                $result->setResultImage($learnersImg);
                $result->setResultMessage("Что-то пошло не так...");
                $result->setPercent(0);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($result);
                $entityManager->flush();
            }
            return $this->render('passing_course/passing.html.twig', [
                'passing' => $passing,
                'course' => $passing->getCourse(),
                'curLesson' => $passing->getCurLesson(),
                'curStage' => $passing->getCurStage(),
                'result' => $result
            ]);
        }
        return $this->render('passing_course/passing.html.twig', [
            'passing' => $passing,
            'course' => $passing->getCourse(),
            'curLesson' => $passing->getCurLesson(),
            'curStage' => $passing->getCurStage(),
            'result' => $passing->isDrawingCheckResult($stage)
        ]);

    }

    /**
     * @Route("/learner/passing/result_passing/{courseId}/{passingId}", name="result_passing", methods={"GET"})
     */
    public function result_passing(Request $request, $courseId, $passingId): Response
    {
        $curUser = $this->getUser();
        $course = $this->courseRepository->findOneBy(['id' => $courseId]);
        $passing = $this->passingRepository->findOneBy(['id' => $passingId]);

        $all_results = $passing->getResults();
        $success = 0;
        $wrong = 0;
        $results = $passing->getResults();
        foreach ($results as &$result) {
            if ($result->getPercent() >= 80) {
                $success++;
            }else{
                $wrong++;
            }
        }
        $entityManager = $this->getDoctrine()->getManager();
        $passing->setIsComplited(true);
        $entityManager->flush();
        return $this->render('passing_course/result_passing.html.twig', [
            'passing' => $passing,
            'course' => $course,
            'success' => $success,
             'wrong' => $wrong
        ]);
    }
}
