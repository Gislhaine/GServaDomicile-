<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
{
    $this->passwordHasher = $passwordHasher;

    
    }
   

    
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request,ContactRepository $repository): Response
    {
         //création du formulaire
         $form = $this->createForm(ContactType::class);

         //on rempli le form avec les données de l'utilisateur
         $form->handleRequest($request);

         //verification si le form est envoyé et est valide
         if($form->isSubmitted() && $form->isValid()){
             //récuperer les données de l'utilisateur
             $contact= $form->getData();
         
             //Enregistrer le message dans la base de données
             $repository->save($contact, true);


             //redirection vers la page d'accueil
             
             return $this->redirectToRoute('app_home_home');
             // $this->addFlash('success', "Votre compte a bien été créé. Bienvenue !");
         }

         
        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ContactController',
        ]);

        
    }

    #[Route('/contactsparticuliers', name: 'app_contactsparticuliers')]
    
    public function contactsparticuliers(Request $request,ContactRepository $repository): Response
    {
        $contact = new Contact();    
        
        $form=$this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid ()){
           
            //envoyer un mail
            $formData = $form->getData();

        //Enregistrer le message dans la base de données
        $repository->save($contact, true);

        $this->addFlash('succes', "Message envoyé, nous vous reviendrons bientôt !");

        //redirection vers la page d'accueil
        return $this->redirectToRoute('app_contactsparticuliers');
        }
               
        return $this->render('home/contactsparticuliers.html.twig', [
            'form' => $form->createView()
            
        ]);

        
        if ($form->isSubmitted() && $form->isValid ())
        return $this->redirectToRoute('app_home_pages',[

        ]);  
       
    }


    #[Route('/contactsprofessionnels', name: 'app_contactsprofessionnels')]
   
    public function contactsprofessionnels(Request $request,ContactRepository $repository): Response
    {
        $contact = new Contact();    
        
        $form=$this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid ()) {
            
           //envoyer un mail
           $formData = $form->getData();

            //Enregistrer le message dans la base de données
        $repository->save($contact, true);

         $this->addFlash('succes', "Message envoyé, nous vous reviendrons bientôt !");
         
         //redirection vers la page d'accueil
         return $this->redirectToRoute('app_contactsprofessionnels');
        }


        return $this->render('home/contactsprofessionnels.html.twig', [
                'form' => $form->createView()
            ]);       
        

        if ($form->isSubmitted() && $form->isValid ())
        return $this->redirectToRoute('app_home_pages',[

        ]);

       
    }
    public function configureMenuItems(): iterable{
        yield TextareaField::new('description', 'Description', 'message', 'Message')->renderAsHtml();
        yield TextareaField::new('description', 'Description', 'message', 'Message')->setMaxLength(15);

        

// inside configureFields() you have access to the current page name
// use it to set different values per page
//yield TextareaField::new('...')->setMaxLength($pageName === Crud::PAGE_DETAIL ? 1024 : 32);
    }
    
}
