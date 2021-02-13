<?php

namespace App\Controller\Admin;

use App\Entity\Auto;
use App\Entity\Brand;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(): Response
    {
        $productListUrl = $this->get(CrudUrlGenerator::class)->build()->setController(UserCrudController::class)->generateUrl();

        return $this->redirect($productListUrl);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Lego Car');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Пользователи', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Автомобили', 'fas fa-car-side', Auto::class);
        yield MenuItem::linkToCrud('Бренды', 'fas fa-copyright', Brand::class);
        //yield MenuItem::linkToCrud('Бренды', 'fas fa-users', Brand::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
