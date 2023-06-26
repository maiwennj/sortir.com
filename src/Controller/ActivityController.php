<?php

namespace App\Controller;

use App\Entity\Activity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Clock\now;

#[Route('/activity', name: 'activity_')]
class ActivityController extends AbstractController
{
    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $activity = new Activity();
        $activity->setName("test 1");
        $activity->setStartDate(now());
        $activity->setDuration(180);
        $activity->setClosingDate( now());
        $activity->setMaxRegistration(10);
        $activity->setDescription("blablablablablablablablablablabla");
        $activity->setState(2);
        $activity->setPictureUrl('blabalblablabalbal');

        $entityManager->persist($activity);
        $entityManager->flush();

        return $this->render('activity/create.html.twig');
    }

    #[Route('/',name:'list')]
    public function list(ActivityRepository $activityRepository):Response
    {
        $activities = $activityRepository->findAll();

        return $this->render('activity/list.html.twig',[
            'activities'=>$activities
        ]);
    }


    #[Route('/{id}',
        name:'details',
        requirements: ["id" => "\d+"]
    )]
    public function details($id, ActivityRepository $activityRepository):Response
    {
        $activity = $activityRepository->find($id);
        if(!$activity){
            return $this->redirectToRoute('activity_list');
        }
        return $this->render('activity/detail.html.twig',[
            'activity'=>$activity
        ]);
    }

    #[Route('/update',name:'update')]
    public function update()
    {

    }

    #[Route('/cancel',name:'cancel')]
    public function cancel()
    {

    }

}
