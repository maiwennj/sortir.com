<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\State;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/create', name: 'app_site')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $site = new Site();
        $site->setSiteName("la Roche sur yon");
        $entityManager->persist($site);
        $entityManager->flush();

        return $this->render('site/create.html.twig');
    }


}
