<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Проект')
            ->setEntityLabelInPlural('Проекты')
            ->setPageTitle('new', 'Создать проект.')
            ->setSearchFields([
                'cmsTitle',
            ])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        //# FIELDS INITIALIZATION:
        [$id, $createdAt, $updatedAt] = CrudDefaults::getAdminFields();
        $name = TextField::new('cmsTitle')
            ->setLabel('Имя')
        ;
        $tvId = TextField::new('tvId')
            ->setLabel('TopVisor ID')
        ;
        $ymId = TextField::new('ymId')
            ->setLabel('Y.Metrika ID')
        ;
        $isActive = BooleanField::new('isActive')
            ->setLabel('Активен')
        ;
        $url = UrlField::new('url')
            ->setLabel('Адрес сайта')
        ;
        $client = AssociationField::new('client')
            ->setCrudController(ClientCrudController::class)
            ->autocomplete()
            ->setLabel('Клиент')
        ;
        $keywordGroups = AssociationField::new('keywordGroups')
            ->setCrudController(KeywordGroupCrudController::class)
            ->autocomplete()
            ->setLabel('Группы ключей')
        ;
        $etxtTasks = AssociationField::new('etxtTasks')
            ->setCrudController(EtxtTaskCrudController::class)
            ->autocomplete()
            ->setLabel('Текстовки Etxt')
        ;
        //# FIELDS GROUPS (ORDER: index, new, details, form):
        $adminFieldsOnDetail = [
            FormField::addPanel('Информация для администратора'),
            $id,
            $isActive,
            $createdAt,
            $updatedAt,
        ];
        $commonFormFields = [
            $name,
            $url,
            $tvId,
            $ymId,
            $client,
            $keywordGroups,
            $etxtTasks,
        ];
        //# FIELDS DISPLAY RULES PER PAGE NAME:
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                ...$commonFormFields,
                $createdAt,
                $updatedAt,
            ];
        }
        if (Crud::PAGE_NEW === $pageName) {
            return [
                ...$commonFormFields,
            ];
        }
        return [
            ...$commonFormFields,
            ...$adminFieldsOnDetail,
        ];
    }
}
