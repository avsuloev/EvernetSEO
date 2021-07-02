<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @todo: check if one of transformers is unnecessary.
 */
class BoolingIntType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Unlike in other types, where the data is NULL by default, it
        // needs to be a Boolean here. setData(null) is not acceptable
        // for checkboxes and radio buttons (unless a custom model
        // transformer handles this case).
        // We cannot solve this case via overriding the "data" option, because
        // doing so also calls setDataLocked(true).
        $builder->setData($options['data'] ?? false);
        $builder
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($integer) {
                        // transform the integer to a boolean
                        return 1 === $integer;
                    },
                    function ($boolean) {
                        // transform the boolean back to an integer
                        return $boolean ? 1 : 0;
                    },
                )
            )
        ;
        $builder->addViewTransformer(new BooleanToStringTransformer((1 === $options['value']), $options['false_values']));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'value' => $options['value'],
            'checked' => null !== $form->getViewData(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $emptyData = function (FormInterface $form, $viewData) {
            return $viewData;
        };

        $resolver->setDefaults([
            'value' => '1',
            'empty_data' => $emptyData,
            'compound' => false,
            'false_values' => [null],
            'invalid_message' => function (Options $options, $previousValue) {
                return ($options['legacy_error_messages'] ?? true)
                    ? $previousValue
                    : 'The checkbox has an invalid value.';
            },
            'is_empty_callback' => static function ($modelData): bool {
                return false === $modelData;
            },
        ]);

        $resolver->setAllowedTypes('false_values', 'array');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'checkbox';
    }
}
