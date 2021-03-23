<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(UserRepository $userRepository): Response
    {
        $curUser = $this->getUser();
        if($curUser){
            $userRole = $curUser->getUserType();
            switch ($userRole) {
                case User::TEACHER:
                    return $this->redirectToRoute('teacher_homepage');
                case User::LEARNER:
                    return $this->redirectToRoute('learner_homepage');
            }
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
