<?php

declare(strict_types=1);

namespace App\Controller\Admin\Common;

use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

// TODO: try to add basic configureCrud() options for twig FormTheme.
final class CrudDefaults
{
    /**
     * @return array{
     *                IdField       $id,
     *                DateTimeField $createdAt,
     *                DateTimeField $updatedAt,
     *                }
     */
    public static function getAdminFields(): array
    {
        $id = IdField::new('id')
            ->setFormTypeOption('disabled', 'disabled')
        ;
        $createdAt = DateTimeField::new('createdAt')
            ->setLabel('Запись создана')
            ->setFormTypeOption('disabled', 'disabled')
            ->renderAsNativeWidget()
        ;
        $updatedAt = DateTimeField::new('updatedAt')
            ->setLabel('Запись обновлена')
            ->setFormTypeOption('disabled', 'disabled')
            ->renderAsNativeWidget()
        ;

        return [
            $id,
            $createdAt,
            $updatedAt,
        ];
    }

    private function __construct()
    {
    }
}
