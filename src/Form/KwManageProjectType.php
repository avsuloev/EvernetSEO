<?php

namespace App\Form;

use App\Controller\KeywordsManagementController;
use App\Entity\Project;
use App\Service\StimulusAttributesService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class KwManageProjectType extends AbstractType
{
    private StimulusAttributesService $stimulus;

    public function __construct()
    {
        $this->stimulus = new StimulusAttributesService(KeywordsManagementController::STIMULUS_CTRL);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query', EntityType::class, [
                'class' => Project::class,
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('submit', SubmitType::class)
        ;
    }
}
