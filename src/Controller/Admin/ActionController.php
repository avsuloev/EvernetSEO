<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Service\StimulusAttributesService;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActionController extends AbstractController
{
    private const STIMULUS_CTRL = 'keywords-management';

    private StimulusAttributesService $stimulus;

    #[Pure]
    public function __construct()
    {
        $this->stimulus = new StimulusAttributesService(self::STIMULUS_CTRL);
    }

    /**
     * Batch action.
     */
    #[Route('/{_locale<%app.supported_locales%>}/admin/action/change-project-form', name: 'change_project_form')]
    public function changeProjectForm(): Response
    {
        $form = $this->createFormBuilder()
            ->add('project', EntityType::class, [
                // looks for choices from this entity
                'class' => Project::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'cmsTitle',
                'label' => 'Проект',
            ])
            ->getForm()
        ;

        return $this->render('_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Batch action.
     */
    #[Route('/{_locale<%app.supported_locales%>}/admin/action/change-url-form', name: 'change_url_form')]
    public function changeUrlForm(): Response
    {
        $form = $this->createFormBuilder()
            ->add('url', TextType::class, [])
            ->getForm()
        ;

        return $this->render('_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Batch action.
     */
    #[Route('/{_locale<%app.supported_locales%>}/admin/action/kw-update-position', name: 'kw_update_position')]
    public function updateKwPosition()
    {
        return $this->render('admin/crud/actions/_confirmation.html.twig', [
            'content' => "I'm a Form!",
        ]);
    }
}
