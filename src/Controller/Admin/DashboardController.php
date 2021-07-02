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
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EvernetSEO');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Клиенты', 'far fa-address-card', Client::class);
        yield MenuItem::linkToCrud('Проекты', 'far fa-newspaper', Project::class);
        yield MenuItem::linkToCrud('Группы ключей', 'fas fa-project-diagram', KeywordGroup::class);
        yield MenuItem::linkToCrud('Ключи', 'fas fa-search-plus', Keyword::class);
        yield MenuItem::linkToCrud('Etxt: текстовки', 'far fa-file-alt', EtxtTask::class);

        yield MenuItem::section('Etxt templates');
        yield MenuItem::linkToCrud('Как нужно писать', 'far fa-edit', EtxtTaskTextRestraints::class);
        yield MenuItem::linkToCrud('Кто может писать', 'fas fa-user-lock', EtxtTasksAuthorRestraints::class);
        yield MenuItem::linkToCrud('Тип текста', 'fas fa-superscript', EtxtTaskType::class);
        yield MenuItem::linkToCrud('Автосделка', 'fas fa-magic', EtxtTasksAutoAccept::class);
        yield MenuItem::linkToCrud('Мультизаказы', 'fas fa-tasks', EtxtMultitasking::class);
        yield MenuItem::linkToCrud('Etxt: пул авторов', 'fas fa-user-edit', EtxtAuthor::class);

        yield MenuItem::section('Links');
        yield MenuItem::linkToUrl('Yandex.Metrika', 'fab fa-yandex', 'https://metrika.yandex.ru');
        yield MenuItem::linkToUrl('TopVisor', 'fas fa-search', 'https://topvisor.com/account');
        yield MenuItem::linkToUrl('Etxt', 'fab fa-internet-explorer', 'https://www.etxt.ru/users/signin');
    }
}
