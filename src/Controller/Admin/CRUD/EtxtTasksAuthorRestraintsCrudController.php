<?php

namespace App\Controller\Admin\CRUD;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Etxt\EtxtTaskOptions;
use App\Entity\Etxt\EtxtTasksAuthorRestraints;
use App\Form\Admin\Field\BoolingIntField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtxtTasksAuthorRestraintsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EtxtTasksAuthorRestraints::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Требование к исполнителю')
            ->setEntityLabelInPlural('Требования к исполнителю')
            ->setPageTitle('new', 'Создать требование к исполнителю.')
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
        $isSkillCheckOn = BoolingIntField::new('requireSkillCheck')
            ->setLabel('Учитывать мастерство исполнителя')
        ;
        $whitelistMode = ChoiceField::new('whitelistMode')
            ->setLabel('Доступ для исполнителя')
            ->setChoices([
                'для всех' => EtxtTaskOptions::SET_WHITELIST_MODE['everyone'],
                'для белого списка' => EtxtTaskOptions::SET_WHITELIST_MODE['whitelist'],
                'индивидуально' => EtxtTaskOptions::SET_WHITELIST_MODE['individual'],
            ])
        ;
        $whitelistId = IntegerField::new('whitelistId')
            ->setLabel('Идентификатор исполнителя Etxt')
            ->setHelp('далее будет заменен на данные вайтлиста от Etxt API')
        ;
        $isWhitelistNotifiable = BoolingIntField::new('notifyWhitelisted')
            ->setLabel('Посылать уведомление авторам о доступности заказа')
            ->setHelp('группам и авторам из БС')
        ;
        $isCertifiedOnly = BoolingIntField::new('isCertifiedOnly')
            ->setLabel('Только аттестованные копирайтеры')
            ->setHelp(
                'Только для тематических категорий:'
                .'1. Медицина. 2. Строительство.'
                .'3. Закон и право. 4. Бухгалтерия и финансы'
            )
        ;
        $isGraduatedOnly = BoolingIntField::new('isGraduatedOnly')
            ->setLabel('Только дипломированные копирайтеры')
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
            $isSkillCheckOn,
            $whitelistMode,
            $whitelistId,
            $isWhitelistNotifiable,
            $isCertifiedOnly,
            $isGraduatedOnly,
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
