<?php

namespace App\Controller\Admin\CRUD;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Etxt\EtxtTask;
use App\Entity\Etxt\EtxtTaskOptions;
use App\Form\Admin\Field\BoolingIntField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class EtxtTaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EtxtTask::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Текстовка')
            ->setEntityLabelInPlural('Текстовки')
            ->setPageTitle('new', 'Создать текстовку')
            ->setSearchFields([
                'title',
            ])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        //# FIELDS INITIALIZATION:
        [$id, $createdAt, $updatedAt] = CrudDefaults::getAdminFields();
        $title = TextField::new('title')
            ->setLabel('Имя')
        ;
        $project = AssociationField::new('project')
            ->setCrudController(ProjectCrudController::class)
            ->autocomplete()
            ->setLabel('Проект')
        ;
        $etxtAuthor = AssociationField::new('etxtAuthor')
            ->setCrudController(EtxtAuthorCrudController::class)
            ->autocomplete()
            ->setLabel('Исполнитель')
        ;
        $taskFilename =  TextField::new('taskFilename')
            ->setLabel('Путь к файлу')
        ;
        $isPublicised = BoolingIntField::new('isPublicised')
            ->setLabel('Заказ публикуется')
        ;
        $etxtId = IntegerField::new('etxtId')
            ->setLabel('Etxt ID задачи')
            ->setFormTypeOption('disabled', 'disabled')
        ;
        $taskDescription = TextareaField::new('taskDescription')
            ->setLabel('Описание заказа')
            ->setHelp('не более 10000 символов')
            ->setMaxLength(10000)
        ;
        $taskText = TextareaField::new('taskText')
            ->setLabel('Текст заказа')
            ->setHelp('не более 40000 символов')
            ->setMaxLength(40000)
        ;
        $price = IntegerField::new('price')
            ->setLabel('Цена заказа')
            ->setRequired(true)
        ;
        $pricingMode = ChoiceField::new('pricingMode')
            ->setLabel('Тип цены заказа')
            ->setChoices([
                'за 1000 знаков' => EtxtTaskOptions::SET_PRICING_MODE['1kChars'],
                'за весь заказ' => EtxtTaskOptions::SET_PRICING_MODE['total'],
            ])
        ;
        $deadlineDay = DateField::new('deadlineDdMmYear')
            ->setLabel('Срок сдачи заказа')
            ->setHelp('не более 90 дней, дд.мм.гггг')
        ;
        $deadlineTime = TimeField::new('deadlineHhMm')
            ->setLabel('Время сдачи заказа')
            ->setHelp('чч:мм')
        ;
        $taskFolderId = IntegerField::new('taskFolderId')
            ->setLabel('Etxt ID папки заказа')
        ;
        $keywords = TextareaField::new('keywords')
            ->setLabel('Список ключевых слов через запятую')
            ->setHelp('для типа заказа SEO-копирайтинг (4)')
        ;
        $textRestraints = AssociationField::new('textRestraints')
            ->setCrudController(EtxtTaskTextRestraintsCrudController::class)
            ->autocomplete()
            ->setLabel('Требования к тексту')
        ;
        $authorRestraints = AssociationField::new('authorRestraints')
            ->setCrudController(EtxtTasksAuthorRestraintsCrudController::class)
            ->autocomplete()
            ->setLabel('Требования к исполнителю')
        ;
        $taskType = AssociationField::new('taskType')
            ->setCrudController(EtxtTaskTypeCrudController::class)
            ->autocomplete()
            ->setLabel('Тип текста')
        ;
        $autoacceptPolitic = AssociationField::new('autoacceptPolitic')
            ->setCrudController(EtxtTasksAutoAcceptCrudController::class)
            ->autocomplete()
            ->setLabel('Политика автосделки')
        ;
        $multitaskingPolitic = AssociationField::new('multitaskingPolitic')
            ->setCrudController(EtxtMultitaskingCrudController::class)
            ->autocomplete()
            ->setLabel('Политика мультизаказа')
        ;
        //# FIELDS GROUPS (ORDER: index, new, details, form):
        $adminFieldsOnDetail = [
            FormField::addPanel('Информация для администратора'),
            $id,
            $etxtId,
            $createdAt,
            $updatedAt,
        ];
        $commonFormFields = [
            $title,
            $project,
            $etxtAuthor,
            $isPublicised,
            $taskDescription,
            $taskText,
            $price,
            $pricingMode,
            $deadlineDay,
            $deadlineTime,
            $taskFolderId,
            $keywords,
            $textRestraints,
            $authorRestraints,
            $taskType,
            $autoacceptPolitic,
            $multitaskingPolitic,
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
