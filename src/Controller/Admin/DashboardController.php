<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use App\Controller\Admin\DashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;




class DashboardController extends AbstractDashboardController

{
    #[Route('/admin', name: 'admin')]
        public function index(): Response
    {
        return $this->render('/admin/dashboard.html.twig');
        //return parent::home();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        //$adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
    }



    public function configureDashboard() : Dashboard
    {
        return Dashboard::new()
        ->setTitle("GServicesADomicile")
        ->renderContentMaximized();
    }

    /*#[Route('/admin')]
    public function admin(): Response
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        // ...set chart data and options somehow

        return $this->render('admin/dashboard.html.twig', [
            'chart' => $chart,
        ]);
        
    }*/
    
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
       
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-list', Utilisateur::class);
    }

}
