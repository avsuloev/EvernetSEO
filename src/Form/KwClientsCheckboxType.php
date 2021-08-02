<?php

namespace App\Form;

use App\Entity\Keyword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KwClientsCheckboxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isApproved', CheckboxType::class, [
                'label' => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                ],
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'disabled' => true,
                'label' => false,
            ])
            ->add('url', UrlType::class, [
                'disabled' => true,
                'label' => false,
            ])
            ->add('keywordGroup', TextType::class, [
                'disabled' => true,
                'label' => false,
            ])
            ->add('position', IntegerType::class, [
                'disabled' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => '—',
                ],
            ])
            ->add('frequency', IntegerType::class, [
                'disabled' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => '—',
                ],
            ])
            ->add('clientNote', HiddenType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Keyword::class,
        ]);
    }
}
