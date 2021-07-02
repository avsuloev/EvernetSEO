<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Etxt\EtxtTaskTextRestraints;
use App\Form\Admin\Field\BoolingIntField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtxtTaskTextRestraintsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EtxtTaskTextRestraints::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Требование к тексту')
            ->setEntityLabelInPlural('Требования к тексту')
            ->setPageTitle('new', 'Создать требование к тексту.')
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
        $uniqueScore = IntegerField::new('uniqueScore')
            ->setLabel('Уникальность заказа')
        ;
        $placeOnSite = BoolingIntField::new('placeOnSite')
            ->setLabel('Размещение текста на сайте')
        ;
        $spaceCountMode = BoolingIntField::new('spaceCountMode')
            ->setLabel('Учитывать пробелы при подсчёте символов')
        ;
        $taskSizeInChars = IntegerField::new('taskSizeInChars')
            ->setLabel('Размер заказа в символах')
            ->setHelp('Обязательный параметр при отсутствии параметра text')
        ;
        $completionIs90Percent = BoolingIntField::new('require90PercentCompletion')
            ->setLabel('Проверять минимальный размер результата сдачи')
            ->setHelp('Тексты менее 90% от размера заказа приниматься не будут')
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
            $uniqueScore,
            $placeOnSite,
            $spaceCountMode,
            $taskSizeInChars,
            $completionIs90Percent,
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
