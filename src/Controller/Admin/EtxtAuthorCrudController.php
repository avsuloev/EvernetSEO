<?php

namespace App\Controller\Admin;

use App\Entity\Etxt\EtxtAuthor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EtxtAuthorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EtxtAuthor::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
