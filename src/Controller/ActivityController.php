<?php

namespace App\Controller;

use App\Entity\Activity;

use App\Entity\State;
use App\Entity\UserProfile;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use App\Repository\StateRepository;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/activity', name: 'activity_')]
class ActivityController extends AbstractController
{
    #[Route('/create', name: 'create')]
    public function create(
        EntityManagerInterface $entityManager,
        Request $request,
        StateRepository $stateRepository,
        UserProfileRepository $userProfileRepository
    ): Response
    {
        $activity = new Activity();
        $activityForm = $this->createForm(ActivityType::class, $activity);

        $activityForm->handleRequest($request);
        if($activityForm->isSubmitted() && $activityForm->isValid()){
            try{

                //à modifier pour fonctionner avec le changement de stade et la bdd
                $state = $stateRepository->find(1);

                $activity->setState($state);

                $activity->setOrganiser($this->getUser()->getUserProfile());

                $entityManager->persist($activity);
                $entityManager->flush();
                $this->addFlash('success',"L'activité a bien été créée");
                $this->redirectToRoute('activity_details',["id"=>$activity->getId()]);
            }catch (Exception $exception){
                $this->addFlash('danger',"Le souhait n'a pas été ajouté.");
                return  $this->redirectToRoute('activity_create');
            }

        }

        return $this->render('activity/create.html.twig',[
            'form'=>$activityForm->createView()
            ]);
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

    }}

