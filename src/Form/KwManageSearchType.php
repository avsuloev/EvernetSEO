<?php

namespace App\Form;

use App\Controller\KeywordsManagementController;
use App\Service\StimulusAttributesService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;

class KwManageSearchType extends AbstractType
{
    private StimulusAttributesService $stimulus;

    public function __construct()
    {
        $this->stimulus = new StimulusAttributesService(KeywordsManagementController::STIMULUS_CTRL);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $targetAttr = $this->stimulus->genTargetAttr('search');
        $attr = array_merge($targetAttr, ['placeholder' => 'Search']);

        $builder->add('query', SearchType::class, [
            'attr' => $attr,
            'row_attr' => [
                'class' => 'form-floating',
            ],
        ]);
    }
}
