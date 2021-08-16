<?php

namespace App\Form;

use App\Controller\KeywordsManagementController;
use App\Service\StimulusAttributesService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class KwManageMulticheckType extends AbstractType
{
    private StimulusAttributesService $stimulus;

    public function __construct()
    {
        $this->stimulus = new StimulusAttributesService(KeywordsManagementController::STIMULUS_CTRL);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $actionAttr = $this->stimulus->genActionAttr('multicheck', 'click');
        $targetAttr = $this->stimulus->genTargetAttr('multicheck');
        $attr = array_merge($actionAttr, $targetAttr);

        $builder
            ->add('checkbox', CheckboxType::class, [
                'attr' => $attr,
                'required' => false,
                'label' => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                ],
            ])
        ;
    }

}
