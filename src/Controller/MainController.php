<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route(['/main','/','home'], name: 'app_main')]
    public function index(): Response{
        return $this->redirectToRoute('activity_list');
    }


}
