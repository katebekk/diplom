<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class TeacherHomepageController extends AbstractController
{
    /**
     * @Route("/teacher/homepage", name="teacher_homepage")
     */
    public function index(): Response
    {
        return $this->render('teacher_homepage/index.html.twig', [
            'controller_name' => 'TeacherHomepageController',
        ]);
    }
}
