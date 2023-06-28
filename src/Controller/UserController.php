<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/user', name: 'user_')]
class UserController extends AbstractController{

    #[Route(path: '/profile/{id}', name: 'profile',requirements: ['id'=>'\d+'])]
    public function profile(UserRepository $userRepository, $id): Response{
        $user = $userRepository->find($id);
        return $this->render('user/details.html.twig',
            ['user' => $user]);
    }

    #[Route(path: '/my_profile', name: 'my_profile')]
    public function myProfile(UserRepository $userRepository, ): Response{
        $user = $userRepository->find($this->getUser()->getId());
        return $this->render('user/my-profile.html.twig',
            ['user' => $user]);
    }

    #[Route(path: '/my_profile_update', name: 'my_profile_update')]
    public function update(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response{
        $user = $this->getUser();
        $formUser = $this->createForm(UserType::class,$user);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()){
            try {
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success','Modifications validées');
                return $this->redirectToRoute('user_my_profile');
            }catch (Exception $exception){
                $this->addFlash('danger','Modifications ratées');
            }
        }


        return $this->render('user/my-profile-update.html.twig',[
            'formUser' => $formUser->createView(),
        ]);
    }




}
