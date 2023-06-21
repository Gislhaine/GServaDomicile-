<?php

namespace App\Controller;

use App\Form\MoncompteType;
use App\Controller\HomeController;
use App\Repository\HomeRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/*#[IsGranted("ROLE_ADMIN")]*/

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home_home')]

    public function home(HomeRepository $repository): Response
    {
        /*$homes= $repository->findAll();*/
        return $this->render('/home/home.html.twig'); 
    }
    #[Route('/apropos', name: 'app_apropos')]

    public function apropos(): Response
    {
      
        return $this->render('/home/apropos.html.twig'); 
    }

    #[Route('/moncompte', name: 'app_moncompte')]

    public function moncompte(UtilisateurRepository $repository): Response
    {
        $utilisateur= $this->getUser();
            return $this->render('/home/moncompte.html.twig', [
            'utilisateur' => $utilisateur,
        
        ]);
        
    }

    #[Route('/mentionslegales', name: 'app_mentionslegales')]

    public function mentions(): Response
    {
      
        return $this->render('/mentions/legales.html.twig'); 
    }


    #[Route('/modif-moncompte', name: 'app_modifMoncompte')]
    public function modifMoncompte(UtilisateurRepository $repository, UserPasswordHasherInterface $hasher, Request $request): Response
    {
        //récuperation de l'utilisateur connecté
        $utilisateur= $this->getUser();

        //creer le formulaire
        $form= $this->createForm(MoncompteType::class, $utilisateur);

        //remplissage du formulaire 
        $form->handleRequest($request);

        //test si form is valid and submitted
        if($form->isSubmitted() && $form->isValid()){
            /*crypter le mot de passe*/
        $cryptedPass= $hasher->hashPassword($utilisateur , $utilisateur->getPassword()); // c'est ici que le mdp ecrit en clair se transforme en hash
        $utilisateur->setPassword($cryptedPass);
   
            //on enregistre les modifications dans la bd via le repo
            $repository->save($utilisateur, true);
            //redirection vers la page mon compte
        
        return $this->redirectToRoute('app_moncompte');
        }

        
        //affichage de la page HTML
        return $this->render('home/modif-moncompte.html.twig', [
            'form' => $form->createView(),
        ]);
    }    


}
/*#[IsGranted("ROLE_ADMIN")] */
/*class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home_home')]

    public function home(HomeRepository $repository): Response
    {
        $homes= $repository->findAll();
        return $this->render('home/home.html.twig',[
            'homes' => $homes,
        ]); 
    }
      

}*/
