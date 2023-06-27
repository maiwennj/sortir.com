<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_location')]
    public function createLocation(EntityManagerInterface $entityManager,Request $request): Response
    {
        $location = new Location();
        $locationForm=$this->createForm(LocationFormType::class,$location);
        $locationForm->handleRequest($request);
        if ($locationForm->isSubmitted() && $locationForm->isValid()) {
            $entityManager->persist($location);
            $entityManager->flush();

            $this->addFlash('success', 'Lieu ajouté avec succès.');
            return $this->redirectToRoute('app_main');
        }
            return $this->render('location/formLocation.html.twig', [
                'locationForm'=>$locationForm->createView(),
        ]);
    }
}