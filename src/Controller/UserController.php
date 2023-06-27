<?php

namespace App\Controller;

use App\Form\UserProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController{

    #[Route(path: '/update', name: 'update')]
    public function update(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response{
        $user = $this->getUser();
        $userProfile = $this->getUser()->getProfile();
        $formUser = $this->createForm(UserType::class,$user);
        $formUserProfile = $this->createForm(UserProfileType::class,$userProfile);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()){
            try {
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success','Modifications validées');
                return $this->redirect($this->generateUrl('user_profile',['id'=>$user->getId()]));
            }catch (Exception $exception){
                $this->addFlash('danger','Modifications ratées');
            }
        }


        return $this->render('user/update.html.twig',[
            'formUser' => $formUser,
            'formUserProfile'=>$formUserProfile,
        ]);
    }

    #[Route(path: '/{id}', name: 'profile',requirements: ['id'=>'\d+'])]
    public function profile(UserRepository $userRepository, $id): Response
    {
        $user = $userRepository->find($id);
        return $this->render('user/details.html.twig',
            ['user' => $user]);
    }
    #[Route(path: '/my_profile', name: 'my_profile')]
    public function myProfile(UserRepository $userRepository, ): Response
    {
        $user = $userRepository->find($this->getUser()->getId());
        return $this->render('user/my-profile.html.twig',
            ['user' => $user]);
    }


}
