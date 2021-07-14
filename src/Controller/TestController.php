<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Test;
use App\Entity\Question;
use App\Entity\Answer;
use App\Form\TestType;
use App\Repository\TestRepository;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/teacher/test")
 */
class TestController extends AbstractController
{
//    /**
//     * @Route("/make/{course}", name="make_test", methods={"GET","POST"})
//     */
//    public function makeTest(Request $request,  Course $course): Response
//    {
//        /*  return $this->render('test/make_test.html.twig', [
//              'tests' => $testRepository->findAll(),
//          ]);*/
//        $test = new Test();
//        $test->setCourse($course);
//        $question= new Question();
//        $question->setTest($test);
//        $form = $this->createForm(TestType::class, $test);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $course->setTest($test);
//            $test->addQuestion($question);
//
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($test);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('make_test', ['id' => $course->getId()]);
//        }
//
//        return $this->render('test/make_test.html.twig', [
//            'course'=>$course,
//            'test'=>$test,
//            'question'=>$question,
//            'form' => $form->createView(),
//        ]);
//    }

    private $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @Route("/", name="test_index", methods={"GET"})
     */
    public function index(TestRepository $testRepository): Response
    {
        return $this->render('test/index.html.twig', [
            'lessons' => $testRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="test_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('test_index');
        }

        return $this->render('test/new.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/show/{courseId}", name="show_test", methods={"GET"})
     */
    public function show( $courseId): Response
    {
        $course = $this->courseRepository->findOneBy(['id' => $courseId]);

        return $this->render('test/show.html.twig', [
            'test' => $course->getTest(),

        ]);
    }

    /**
     * @Route("/{id}/edit", name="test_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Test $test): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('test_index');
        }

        return $this->render('test/edit.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_delete", methods={"POST"})
     */
    public function delete(Request $request, Test $test): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('my_courses_teacher');
    }


    /**
     * @Route("/make/{courseId}", name="make_test", methods={"GET","POST"})
     */
    public function makeTest(Request $request, $courseId): Response
    {
        $course = $this->courseRepository->findOneBy(['id' => $courseId]);
        $test = new Test();
        $test->setCourse($course);

        if ($request->request->has('submit')) {
            $entityManager = $this->getDoctrine()->getManager();
            $questions = $request->request->get('questions');
            $answers = $request->request->get('answers');
            $isRights = $request->request->get('isRights');
            if (!empty($questions)) {
                foreach ($questions as $key => $questionValue) {
                    $question = new Question();
                    $question->setName($questionValue);
                    $question->setTest($test);
                    for ($i = $key*4; $i < $key*4 + 4; $i++){
                        $answer = new Answer();
                        $answer->setName($answers[$i]);
                        $answer->setIsRight($isRights[$key]);
                        $currentRight = $request->request->get("answer-$key-$i");
                        if(isset($currentRight)){
                            $answer->setIsRight(true);
                        }
                        $answer->setQuestion($question);
                        $question->addAnswer($answer);
                        $entityManager->persist($answer);
                    }
                    $entityManager->persist($question);
                }
            }
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('show_test',['courseId'=> $course->getId()]);
        }

        return $this->render('test/make_test.html.twig', [
            'course' => $course,
            'test' => $test
        ]);
    }

    /**
     * @Route("/{id}", name="question_delete", methods={"POST"})
     */
    public function questionDelete(Request $request, Question $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('make_test', ['id' => $question->getTest()->getCourse()->getId()]);
    }

}
