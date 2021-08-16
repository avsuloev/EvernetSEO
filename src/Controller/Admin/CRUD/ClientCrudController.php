<?php

namespace App\Controller\Admin\CRUD;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Клиент')
            ->setEntityLabelInPlural('Клиенты')
            ->setPageTitle('new', 'Создать клиента.')
            ->setSearchFields([
                'name',
                'email',
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
        $email = EmailField::new('email')
            ->setLabel('email')
        ;
        $hasKwAccess = BooleanField::new('hasKwAccess')
            ->setLabel('Доступ к ключам')
        ;
        $projects = AssociationField::new('projects')
            ->setCrudController(ProjectCrudController::class)
            ->setLabel('Проекты')
            // ->autocomplete()
            ->setCustomOption('by_reference', false)
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
            $email,
            $hasKwAccess,
            $projects,
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

        // yield TextField::new('name')->setLabel((new \ReflectionClass($this))->getMethod(__FUNCTION__)->getName());
        // yield TextField::new('name');
        // yield EmailField::new('email');

        // $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
        //     'html5' => true,
        //     // 'years' => range(date('Y'), date('Y') + 5),
        //     'widget' => 'single_text',
        // ]);
        // if (Crud::PAGE_INDEX === $pageName) {
        //     yield $createdAt->setFormTypeOption('disabled', true);
        // }
    }
}
