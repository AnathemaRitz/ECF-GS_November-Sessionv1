<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Entity\Seller;
use App\Entity\Genre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\User;
use App\Entity\Game;
use App\Entity\Store;
use App\Entity\Order;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(OrderCrudController::class)->generateUrl());


        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');*/
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ECF GS');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Clients', 'fas fa-list', Customer::class);
        yield MenuItem::linkToCrud('Vendeurs', 'fas fa-list', Seller::class);
        yield MenuItem::linkToCrud('Genres', 'fas fa-list', Genre::class);
        yield MenuItem::linkToCrud('Jeux', 'fas fa-list', Game::class);
        yield MenuItem::linkToCrud('Magasins', 'fas fa-list', Store::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-list', Order::class);
       /* yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);*/
        /*yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);*/
    }
}
