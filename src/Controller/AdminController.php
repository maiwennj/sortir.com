<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Site;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\LocationFormType;
use App\Form\SiteType;
use App\Form\UserImportType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin',name: 'admin_')]
class AdminController extends AbstractController
{

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

    #[Route('/', name: 'hub')]
    public function adminHub(): Response{

        return $this->render('admin/index.html.twig',[

        ]);
    }


    #[Route('/user-creation', name: 'user_create')]
    public function addUser(){

    }
    #[Route('/user-import', name: 'user_import')]
    public function importUser(Request $request,SiteRepository $siteRepository, EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher){

        $form = $this->createForm(UserImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            try {
                //********** Handling the file extension
                $file = $form['attachment']->getData();
                $extension = $file->guessExtension();
                if (!$extension) {
                    $extension = 'bin';
                }
                $fileName = rand(1, 99999).'.'.$extension;
                $file->move("./uploaded_files", $fileName);
                //********** end of dealing with the file

                $importFile = file_get_contents('uploaded_files/'.$fileName);
                $importFile = str_replace("\u{FEFF}","",$importFile);
                $importFileLines = explode("\r\n",$importFile);
                array_pop($importFileLines);

                for ($index=0;$index<count($importFileLines);$index++){
                    $importFileLines[$index] = explode(";",$importFileLines[$index]);
                }
                $compteur=0;
                foreach ($importFileLines as list($username,$isAdmin,$isActive,$firstName,$lastName,$site,$phoneNumber,$emailAdress)){
                    $newUserProfile = new UserProfile();
                    $newUserProfile->setFirstName($firstName);
                    $newUserProfile->setLastName($lastName);
                    $newUserProfile->setSite($siteRepository->find($site));
                    $newUserProfile->setPhoneNumber($phoneNumber);
                    $newUserProfile->setEmailAdress($emailAdress);

                    $newUser = new User();
                    $newUser->setUserProfile($newUserProfile);
                    $newUser->setUsername($username);
                    if ($isAdmin){
                        $newUser->setRoles(["ROLE_USER","ROLE_ADMIN"]);
                        $newUser->setIsAdmin(1);
                    }else{
                        $newUser->setRoles(["ROLE_USER"]);
                        $newUser->setIsAdmin(0);
                    }
                    $newUser->setIsActive($isActive);
                    $newUser->setPassword( $userPasswordHasher->hashPassword($newUser,$username));

                    $newUserProfile->setUser($newUser);
                    $entityManager->persist($newUser);
                    $entityManager->persist($newUserProfile);
                    $compteur++;
                }
                $entityManager->flush();


                $this->addFlash('success',"$compteur utilisateur(s) inséré(s) avec succès.");
                return $this->redirectToRoute('admin_user_import');
            }catch (\Exception $exception){
                $this->addFlash('danger',"Impossible d'insérer le fichier d'utilisateurs.");
            }
        }

        return $this->render('admin/user-import.html.twig',[
            'form'=>$form]);
    }

}
