<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\LessonStage;
use App\Form\LessonStageType;
use App\Repository\LessonStageRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher/lessonstage")
 */
class LessonStageController extends AbstractController
{

    private $lessonRepository;
    private $lessonStageRepository;

    public function __construct(
        LessonRepository $lessonRepository,
        LessonStageRepository $lessonStageRepository
    )
    {
        $this->lessonRepository = $lessonRepository;
        $this->lessonStageRepository= $lessonStageRepository;
    }
    /**
     * @Route("/{id}", name="lesson_stage_show", methods={"GET"})
     */
    public function show(LessonStage $lessonStage): Response
    {
        return $this->render('lesson_stage/show.html.twig', [
            'lesson_stage' => $lessonStage,
        ]);
    }

    /**
     * @Route("/{stageId}/edit", name="lesson_stage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $stageId): Response
    {
        $lessonStage = $this->lessonStageRepository->findOneBy(["id"=>$stageId]);
        $form = $this->createForm(LessonStageType::class, $lessonStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('stage_of_lesson',['lessonId'=> $lessonStage->getLesson()->getId()]);
        }

        return $this->render('lesson_stage/edit.html.twig', [
            'lesson_stage' => $lessonStage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lesson_stage_delete", methods={"POST"})
     */
    public function delete(Request $request, LessonStage $lessonStage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lessonStage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lessonStage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stage_of_lesson', ['lessonId' => $lessonStage->getLesson()->getId()]);
    }

    /**
     * @Route("/{lessonId}/stage_of_lesson", name="stage_of_lesson", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function stageOfLesson(Request $request, $lessonId): Response
    {
        $lesson = $this->lessonRepository->findOneBy(["id"=>$lessonId]);
        $lessonStage = new LessonStage();
        $lessonStage->setLesson($lesson);
        $form = $this->createForm(LessonStageType::class, $lessonStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lesson->addLessonStage($lessonStage);
            $file = $request->files->get('lesson_stage')['exampleImageStage'];

            $uploads_directory = $this->getParameter('uploads_image_example_stage');

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $uploads_directory,
                $filename
            );
            $lessonStage->setExampleImageStage($filename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lessonStage);
            $entityManager->flush();

            return $this->redirectToRoute('stage_of_lesson', ['lessonId' => $lesson->getId()]);
        }

        return $this->render('lesson_stage/stage_of_lesson.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }
}
