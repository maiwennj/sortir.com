<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Site;
use App\Form\LocationFormType;
use App\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin',name: 'admin_')]
class AdminController extends AbstractController
{

    #[Route('/location/create', name: 'location_create')]
    public function createLocation(EntityManagerInterface $entityManager,Request $request): Response
    {
        $location = new Location();
        $locationForm=$this->createForm(LocationFormType::class,$location);
        $locationForm->handleRequest($request);
        if ($locationForm->isSubmitted() && $locationForm->isValid()) {
            try {
                $entityManager->persist($location);
                $entityManager->flush();
                $this->addFlash('success', 'Lieu ajouté avec succès.');
                return $this->redirectToRoute('activity_list');
            }catch (\Exception $exception){
                $this->addFlash('danger','Ajout impossible');
            }
        }
        return $this->render('admin/location-site-create.html.twig', [
            'locationForm'=>$locationForm->createView(),
        ]);
    }


    #[Route('/site/create', name: 'site_create')]
    public function create(EntityManagerInterface $entityManager,Request $request): Response
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class,$site);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            try {
                $entityManager->persist($site);
                $entityManager->flush();
                $this->addFlash('success', 'Site ajouté avec succès.');
                return $this->redirectToRoute('activity_list');
            }catch (\Exception $exception){
                $this->addFlash('danger','Ajout impossible');
            }
        }
        return $this->render('admin/site-create.html.twig',[
            'form'=>$form->createView()
        ]);

    }


}
