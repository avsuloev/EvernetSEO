<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class KwImportType extends AbstractType
{
    public const FIELD_NAME = 'kwFile';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::FIELD_NAME, FileType::class, [
                'label' => 'Import from file',
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/csv',
                        ],
                        'mimeTypesMessage' => 'Пожалуйста, загрузите файл формата .xslx или .csv',
                    ]),
                ],
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Импортировать'])
        ;
    }
}
