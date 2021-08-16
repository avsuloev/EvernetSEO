<?php

namespace App\Form;

use App\Model\KwCollectionModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KwManageFieldsetType extends AbstractType
//    implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keywords', CollectionType::class, [
                'entry_type' => KwManageCheckboxType::class,
            ])
            // ->add('multicheck', KwManageMulticheck::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => KwCollectionModel::class,
        ]);
    }
}
