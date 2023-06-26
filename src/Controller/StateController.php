<?php

namespace App\Controller;

use App\Entity\State;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StateController extends AbstractController
{
    #[Route('/createState', name: 'app_state')]
    public function createState(EntityManagerInterface $entityManager): Response
    {
        $states = [
            "Fermé",
            "En création",
            "Ouvert"
        ];

        foreach ($states as $label) {
            $state = new State();
            $state->setLabel($label);
            $entityManager->persist($state);
        }

        $entityManager->flush();

        return $this->render('state/createState.html.twig', [
            'StateController' => 'StateController',
        ]);
    }
}