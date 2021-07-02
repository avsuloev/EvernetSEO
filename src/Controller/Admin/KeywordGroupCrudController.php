<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\KeywordGroup;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class KeywordGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return KeywordGroup::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Группа ключей')
            ->setEntityLabelInPlural('Группы ключей')
            ->setPageTitle('new', 'Создать группу ключей')
            ->setSearchFields([
                'name',
            ])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        //# FIELDS INITIALIZATION:
        [$id, $createdAt, $updatedAt] = CrudDefaults::getAdminFields();
        $name = TextField::new('name')
            ->setLabel('Имя')
        ;
        $project = AssociationField::new('project')
            ->setCrudController(ProjectCrudController::class)
            ->autocomplete()
            ->setLabel('Проект')
        ;
        $keywords = AssociationField::new('keywords')
            ->setCrudController(KeywordCrudController::class)
            ->autocomplete()
            ->setLabel('Ключи')
        ;
        $subgroups = AssociationField::new('subgroups')
            ->setCrudController(KeywordGroupCrudController::class)
            ->autocomplete()
            ->setLabel('Включает подгруппы')
            ->setFormTypeOption('disabled', 'disabled')
        ;
        $supergroups = AssociationField::new('keywords')
            ->setCrudController(KeywordGroupCrudController::class)
            ->autocomplete()
            ->setLabel('Входит в группы')
            ->setFormTypeOption('disabled', 'disabled')
        ;
        //# FIELDS GROUPS (ORDER: index, new, details, form):
        $adminFieldsOnDetail = [
            FormField::addPanel('Информация для администратора'),
            $id,
            $createdAt,
            $updatedAt,
        ];
        $commonFormFields = [
            $name,
            $project,
            $keywords,
            $subgroups,
            $supergroups,
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
