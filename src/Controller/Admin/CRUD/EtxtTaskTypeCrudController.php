<?php

namespace App\Controller\Admin\CRUD;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Etxt\EtxtTaskOptions;
use App\Entity\Etxt\EtxtTaskType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtxtTaskTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EtxtTaskType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Тип заказанного текста')
            ->setEntityLabelInPlural('Типы заказанных текстов')
            ->setPageTitle('new', 'Создать тип текста к заказу.')
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
        $taskTypeId = IntegerField::new('taskTypeId')
            ->setLabel('Идентификатор типа заказа')
            ->setHelp('по умолчанию 1 (копирайтинг)')
        ;
        $taskSubtypeId = ChoiceField::new('taskSubtypeId')
            ->setLabel('Тип текста')
            ->setChoices([
                'не указано' => EtxtTaskOptions::TASK_SUBTYPE_ID['unspecified'],
                'продающий текст' => EtxtTaskOptions::TASK_SUBTYPE_ID['selling'],
                'информационная статья' => EtxtTaskOptions::TASK_SUBTYPE_ID['infoArticle'],
                'новость/пресс-релиз' => EtxtTaskOptions::TASK_SUBTYPE_ID['newsOrPressRelease'],
                'текст для email-рассылки' => EtxtTaskOptions::TASK_SUBTYPE_ID['mailing'],
                'текст для соцсетей' => EtxtTaskOptions::TASK_SUBTYPE_ID['socialNetwork'],
                'отзыв' => EtxtTaskOptions::TASK_SUBTYPE_ID['review'],
            ])
        ;
        $taskCategoryId = IntegerField::new('taskCategoryId')
            ->setLabel('Идентификатор категории заказа')
            ->setHelp('обязательное поле')
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
            $taskTypeId,
            $taskSubtypeId,
            $taskCategoryId,
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
