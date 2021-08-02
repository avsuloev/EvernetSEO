<?php

namespace App\Controller\Admin\CRUD;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Keyword;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
                'keywordGroup.name',
            ])
            ->showEntityActionsAsDropdown()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $tvApiUpdate = Action::new('tvApiUpdate', 'Обновить позицию', 'fa fa-file')
            ->linkToRoute('')
        ;
        $changeUrl = Action::new('changeUrl', 'Изменить адрес сайта', 'fa fa-file')
            ->linkToRoute('change_url_form')
            ->addCssClass('btn btn-primary')
            ->setIcon('fa fa-user-check')
            ->setHtmlAttributes(['data-action' => 'modal-form#openModalChangeProjectOnSelected'])
        ;
        $tvApiUpdateGlobal = Action::new('tvApiUpdateGlobal', 'Обновить все позиции', 'fa fa-file')
            ->linkToRoute('')
            ->createAsGlobalAction()
            ->addCssClass('btn btn-secondary')
        ;

        return $actions
            ->add(Crud::PAGE_INDEX, $tvApiUpdate)
            ->add(Crud::PAGE_INDEX, $tvApiUpdateGlobal)
            ->add(Crud::PAGE_INDEX, $changeUrl)
            ->addBatchAction(Action::new('tvApiUpdateSelected', 'Обновить позиции')
                ->linkToRoute('')
                ->addCssClass('btn btn-primary')
                ->setIcon('fa fa-user-check'))
            ->addBatchAction(Action::new('changeUrlOnSelected', 'Изменить адрес сайта')
                ->linkToRoute('')
                ->addCssClass('btn btn-primary')
                ->setIcon('fa fa-user-check'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        //# FIELDS INITIALIZATION:
        [$id, $createdAt, $updatedAt] = CrudDefaults::getAdminFields();
        $name = TextField::new('name')
            ->setLabel('Ключ')
        ;
        if (Crud::PAGE_NEW === $pageName || Crud::PAGE_EDIT === $pageName) {
            $url = TextField::new('url')
                ->setLabel('Адрес сайта')
            ;
        } else {
            $url = UrlField::new('url')
                ->setLabel('Адрес сайта')
            ;
        }
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
            ->setFormTypeOption('disabled', 'disabled')
        ;
        $frequency = IntegerField::new('frequency')
            ->setLabel('Частота')
            ->setFormTypeOption('disabled', 'disabled')
        ;
        $clientNote = TextareaField::new('clientNote')
            ->setLabel('Заметка клиента')
            ->setFormTypeOption('disabled', 'disabled')
        ;
        //# FIELDS GROUPS (ORDER: index, new, details, form):
        $adminFieldsOnDetail = [
            FormField::addPanel('Информация для администратора'),
            $id,
            $isApproved,
            $clientNote,
            $createdAt,
            $updatedAt,
        ];
        $commonFormFields = [
            $name,
            $url,
            $keywordGroup,
        ];
        //# FIELDS DISPLAY RULES PER PAGE NAME:
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                ...$commonFormFields,
                $position,
                $frequency,
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
            $position,
            $frequency,
            ...$adminFieldsOnDetail,
        ];
    }
}
