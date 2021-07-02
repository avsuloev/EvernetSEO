<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Keyword;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class KeywordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Keyword::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Ключ')
            ->setEntityLabelInPlural('Ключи')
            ->setPageTitle('new', 'Создать ключ')
            ->setSearchFields([
                'name',
                'url',
                'keywordGroup',
            ])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        //# FIELDS INITIALIZATION:
        [$id, $createdAt, $updatedAt] = CrudDefaults::getAdminFields();
        $name = TextField::new('name')
            ->setLabel('Ключ')
        ;
        $url = UrlField::new('url')
            ->setLabel('Адрес сайта')
        ;
        $isApproved = BooleanField::new('isApproved')
            ->setLabel('Одобрен клиентом')
            ->setFormTypeOption('disabled', 'disabled')
        ;
        $keywordGroup = AssociationField::new('keywordGroup')
            ->setCrudController(KeywordGroupCrudController::class)
            ->autocomplete()
            ->setLabel('Группа ключей')
        ;
        $position = IntegerField::new('position')
            ->setLabel('Позиция')
        ;
        $frequency = IntegerField::new('frequency')
            ->setLabel('Частота')
        ;
        //# FIELDS GROUPS (ORDER: index, new, details, form):
        $adminFieldsOnDetail = [
            FormField::addPanel('Информация для администратора'),
            $id,
            $isApproved,
            $createdAt,
            $updatedAt,
        ];
        $commonFormFields = [
            $name,
            $url,
            $keywordGroup,
            $position,
            $frequency,
        ];
        //# FIELDS DISPLAY RULES PER PAGE NAME:
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                ...$commonFormFields,
                $isApproved,
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
