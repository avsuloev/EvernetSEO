<?php

namespace App\Controller\Admin\CRUD;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Etxt\EtxtMultitasking;
use App\Form\Admin\Field\BoolingIntField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtxtMultitaskingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EtxtMultitasking::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Условие мультизаказа')
            ->setEntityLabelInPlural('Условия мультизаказов')
            ->setPageTitle('new', 'Создать условие мультизаказа.')
            ->setSearchFields([
                'cmsTitle',
            ])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        //# FIELDS INITIALIZATION:
        [$id, $createdAt, $updatedAt] = CrudDefaults::getAdminFields();

        $cmsTitle = TextField::new('cmsTitle')
            ->setLabel('Имя')
        ;
        $isMultitaskOn = BoolingIntField::new('isMultitask')
            ->setLabel('Мультизаказ включён')
        ;
        $multitoneMode = BoolingIntField::new('multitoneMode')
            ->setLabel('Один мультизаказ одному исполнителю')
        ;
        $multitasksTotal = IntegerField::new('multitasksCounted')
            ->setLabel('Число мультизаказов')
        ;
        //# FIELDS GROUPS (ORDER: index, new, details, form):
        $adminFieldsOnDetail = [
            FormField::addPanel('Информация для администратора'),
            $id,
            $createdAt,
            $updatedAt,
        ];
        $commonFormFields = [
            $cmsTitle,
            $isMultitaskOn,
            $multitoneMode,
            $multitasksTotal,
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
