<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\LessonStage;
use App\Entity\Reference;
use App\Form\ReferenceType;
use App\Repository\ReferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reference")
 */
class ReferenceController extends AbstractController
{
    /**
     * @Route("/", name="reference_index", methods={"GET"})
     */
    public function index(ReferenceRepository $referenceRepository): Response
    {
        return $this->render('reference/index.html.twig', [
            'references' => $referenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reference_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reference = new Reference();
        $form = $this->createForm(ReferenceType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reference);
            $entityManager->flush();

            return $this->redirectToRoute('reference_index');
        }

        return $this->render('reference/new.html.twig', [
            'reference' => $reference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reference_show", methods={"GET"})
     */
    public function show(Reference $reference): Response
    {
        return $this->render('reference/show.html.twig', [
            'reference' => $reference,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reference_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reference $reference): Response
    {
        $form = $this->createForm(ReferenceType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reference_index');
        }

        return $this->render('reference/edit.html.twig', [
            'reference' => $reference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reference_delete", methods={"POST"})
     */
    public function delete(Request $request, Reference $reference): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reference->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reference_of_stage',['id'=>$reference->getLessonStage()->getId()]);
    }
    /**
     * @Route("/{id}/reference_of_stage", name="reference_of_stage", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function referenceOfStage(Request $request, LessonStage $stage): Response
    {
        $reference = new Reference();
        $reference->setLessonStage($stage);
        $form = $this->createForm(ReferenceType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stage->addReferenceImage($reference);
            $file = $request->files->get('reference')['drawingImage'];

            $uploads_directory = $this->getParameter('uploads_image_reference');

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $uploads_directory,
                $filename
            );
            $reference->setDrawingImage($filename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reference);
            $entityManager->flush();
            return $this->redirectToRoute('reference_of_stage', ['id' => $stage->getId()]);
        }

        return $this->render('reference/reference_of_stage.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }
}
