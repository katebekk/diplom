<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LearnerHomepageController extends AbstractController
{
    /**
     * @Route("/learner/homepage", name="learner_homepage")
     */
    public function index(): Response
    {
        return $this->render('learner_homepage/index.html.twig', [
            'controller_name' => 'LearnerHomepageController',
        ]);
    }
}
