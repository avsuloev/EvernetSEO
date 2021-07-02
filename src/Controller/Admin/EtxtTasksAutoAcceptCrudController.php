<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Etxt\EtxtTasksAutoAccept;
use App\Form\Admin\Field\BoolingIntField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtxtTasksAutoAcceptCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EtxtTasksAutoAccept::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Условие автосделки')
            ->setEntityLabelInPlural('Условия автосделки')
            ->setPageTitle('new', 'Создать условие автосделки.')
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
        $isAutoAcceptOn = BoolingIntField::new('autoAccept')
            ->setLabel('Автопринятие заявки на исполнение')
        ;
        $minRating = IntegerField::new('autoAcceptMinRating')
            ->setLabel('Требовать минимальный рейтинг')
        ;
        $minPositiveReviews = IntegerField::new('autoAcceptMinPositiveReviews')
            ->setLabel('Требовать минимум положительных отзывов')
        ;
        $maxNegativeReviews = IntegerField::new('autoAcceptMinPositiveReviews')
            ->setLabel('Требовать максимум отрицательных отзывов')
        ;
        $allowedSkillLvl = IntegerField::new('autoAcceptMinPositiveReviews')
            ->setLabel('Идентификатор уровня мастерства исполнителя')
            ->setHelp('по умолчанию 0 (без квалификации)')
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
            $isAutoAcceptOn,
            $minRating,
            $minPositiveReviews,
            $maxNegativeReviews,
            $allowedSkillLvl,
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
