<?php

namespace App\Controller\Admin\CRUD;

use App\Controller\Admin\Common\CrudDefaults;
use App\Entity\KeywordGroup;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use Symfony\Component\Uid\Ulid;

class KeywordGroupCrudController extends AbstractCrudController
{
    public function __construct(
        private AdminContextProvider $adminContextProvider,
    ) {
    }

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
                'project.cmsTitle',
            ])
        ;
    }

//    public function configureAssets(Assets $assets): Assets
//    {
//        return $assets
//            ->addWebpackEncoreEntry('admin')
//        ;
//    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->addBatchAction(Action::new('changeProjectOnSelected', 'Изменить проект')
                ->linkToRoute('change_project_form')
                ->addCssClass('btn btn-primary')
                ->setIcon('fa fa-user-check')
                ->setHtmlAttributes([
                    'data-action' => 'modal-form#openModalChangeUrlOnSelected',
//                    'data-action' => 'modal-form#openModalChangeUrlOnSelected',
                ])
            )
        ;
    }

    public function configureFields(string $pageName): iterable
    {
//        $idFilter = fn (?KeywordGroup $kwGroup, string $id) => $kwGroup ? $kwGroup->getId() : null;
        $entityId = '';
        if (Crud::PAGE_INDEX !== $pageName && Crud::PAGE_NEW !== $pageName) {
            /** @var Ulid $entityId */
            $entityId = $this->adminContextProvider->getContext()->getEntity()->getInstance()->getId();
            $entityId = $entityId->toBinary();
        }

        //# FIELDS INITIALIZATION:
        [$id, $createdAt, $updatedAt] = CrudDefaults::getAdminFields();
        $name = TextField::new('name')
            ->setLabel('Имя')
        ;
        $project = AssociationField::new('project')
            ->setCrudController(ProjectCrudController::class)
            ->autocomplete()
            ->setLabel('Проект')
            ->setRequired(true)
        ;
        $keywords = AssociationField::new('keywords')
            ->setCrudController(KeywordCrudController::class)
            // ->autocomplete()
            ->setLabel('Ключи')
        ;
        // $subgroupsOnEdit = AssociationField::new('subgroups')
        //     ->setCrudController(__CLASS__)
        //     // ->autocomplete()
        //     ->setLabel('Включает подгруппы')
        //     ->setFormTypeOptions([
        //         'query_builder' => function (KeywordGroupRepository $repo) use ($entityId) {
        //             return $repo->findAllExcludingAllSub($entityId);
        //         },
        //     ])
        //     ->setHelp('Указывайте только дочернюю группу, без полной вложенности')
//            ->setQueryBuilder()
        ;
        // $supergroupOnEdit = AssociationField::new('supergroup')
        //     ->setCrudController(__CLASS__)
        //     // ->autocomplete()
        //     ->setLabel('Входит в группы')
        //     ->setFormTypeOptions([
        //         'query_builder' => function (KeywordGroupRepository $repo) use ($entityId) {
        //             return $repo->findAllExcludingAllSuper($entityId);
        //         },
        //     ])
        //     ->setHelp('Указывайте только родительскую группу, без полной вложенности')
//            ->setFormTypeOption('disabled', 'disabled')
        ;
        $subgroups = AssociationField::new('subgroups')
            ->setCrudController(__CLASS__)
            ->setLabel('Включает подгруппы')
        ;
        $supergroup = AssociationField::new('supergroup')
            ->setCrudController(__CLASS__)
            // ->autocomplete()
            ->setLabel('Родительская группа')
        ;
        // $nestingLvl = IntegerField::new('nestingLvl')
        //     ->setLabel('Уровень вложенности группы')
        //     ->setFormTypeOption('disabled', 'disabled')
        // ;
        // $isExcludedAsSub = BooleanField::new('isExcludedAsSub')
        //     ->setLabel('Запретить как подгруппу')
        //     ->setHelp('Исключить из списка при добавлении подгруппы в группах ключей')
        // ;

        //# FIELDS GROUPS (ORDER: index, new, details, form):
        $adminFieldsOnDetail = [
            FormField::addPanel('Информация для администратора'),
            $id,
            // $nestingLvl,
            $createdAt,
            $updatedAt,
        ];
        $commonFormFields = [
            $name,
            $project,
            $keywords,
            $supergroup,
            $subgroups,
        ];
        //# FIELDS DISPLAY RULES PER PAGE NAME:
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                ...$commonFormFields,
                // $isExcludedAsSub->setLabel('Корневая'),
                // $nestingLvl->setLabel('Вложенность'),
                $createdAt,
                $updatedAt,
            ];
        }
        if (Crud::PAGE_NEW === $pageName) {
            return [
                ...$commonFormFields,
                // $isExcludedAsSub,
            ];
        }
        if (Crud::PAGE_EDIT === $pageName) {
            return [
                // $subgroupsOnEdit,
                // $supergroupOnEdit,
                // $name,
                // $project,
                // $keywords,
                ...$commonFormFields,
                // $isExcludedAsSub,
                ...$adminFieldsOnDetail,
            ];
        }

        return [
            ...$commonFormFields,
            // $isExcludedAsSub,
            ...$adminFieldsOnDetail,
        ];
    }
}
