<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\Etxt\EtxtAuthor;
use App\Entity\Etxt\EtxtMultitasking;
use App\Entity\Etxt\EtxtTask;
use App\Entity\Etxt\EtxtTasksAuthorRestraints;
use App\Entity\Etxt\EtxtTasksAutoAccept;
use App\Entity\Etxt\EtxtTaskTextRestraints;
use App\Entity\Etxt\EtxtTaskType;
use App\Entity\Keyword;
use App\Entity\KeywordGroup;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/{_locale<%app.supported_locales%>}/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EvernetSEO');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Management');
        yield MenuItem::linkToCrud('Clients', 'far fa-address-card', Client::class);
        yield MenuItem::linkToCrud('Projects', 'far fa-newspaper', Project::class);
        yield MenuItem::linkToCrud('Key groups', 'fas fa-project-diagram', KeywordGroup::class);
        yield MenuItem::linkToCrud('Keywords', 'fas fa-search-plus', Keyword::class);
        yield MenuItem::linkToCrud('Etxt: texts', 'far fa-file-alt', EtxtTask::class);

        yield MenuItem::section('Templates for Etxt');
        yield MenuItem::linkToCrud('Instructions on writing', 'far fa-edit', EtxtTaskTextRestraints::class);
        yield MenuItem::linkToCrud('Who can write', 'fas fa-user-lock', EtxtTasksAuthorRestraints::class);
        yield MenuItem::linkToCrud('Text type', 'fas fa-superscript', EtxtTaskType::class);
        yield MenuItem::linkToCrud('Autodeal', 'fas fa-magic', EtxtTasksAutoAccept::class);
        yield MenuItem::linkToCrud('Multitasks', 'fas fa-tasks', EtxtMultitasking::class);
        yield MenuItem::linkToCrud('Authors pool', 'fas fa-user-edit', EtxtAuthor::class);

        yield MenuItem::section('External accounts');
        yield MenuItem::linkToUrl('Yandex.Metrika', 'fab fa-yandex', 'https://metrika.yandex.ru');
        yield MenuItem::linkToUrl('TopVisor', 'fas fa-search', 'https://topvisor.com/account');
        yield MenuItem::linkToUrl('Etxt', 'fab fa-internet-explorer', 'https://www.etxt.ru/users/signin');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // the first argument is the "template name", which is the same as the
            // Twig path but without the `@EasyAdmin/` prefix
            ->overrideTemplates([
                'layout' => 'admin/layout.html.twig',
            ])
        ;
    }
}
