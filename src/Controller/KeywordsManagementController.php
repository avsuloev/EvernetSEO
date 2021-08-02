<?php

namespace App\Controller;

use App\Form\KwClientFieldsetType;
use App\Model\KwCollectionModel;
use App\Service\AuthenticatedClientService;
use App\Service\StimulusAttributesService;
use Flasher\Prime\FlasherInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KeywordsManagementController extends AbstractController
{
    private const STIMULUS_CTRL = 'keywords-management';

    private StimulusAttributesService $stimulus;

    #[Pure]
    public function __construct()
    {
        $this->stimulus = new StimulusAttributesService(self::STIMULUS_CTRL);
    }

    /**
     * @throws \Exception
     */
    #[Route(path: '/{_locale<%app.supported_locales%>}/manage-keywords', name: 'manage_keywords')]
    public function index(
        AuthenticatedClientService $authenticatedClient,
        FlasherInterface $flasher,
        Request $request,
    ): Response {
        // make sure the user is authenticated first
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $kwCollection = $authenticatedClient->getAllKeywords();

        $form = $this->createForm(KwClientFieldsetType::class, $kwCollection);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$kwCollection` variable has also been updated
            /** @var KwCollectionModel $kwCollection */
            $kwCollection = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($kwCollection->getKeywords() as $keyword) {
                $entityManager->persist($keyword);
            }
            $entityManager->flush();

            // $flasher
            //     ->addSuccess('This notification will be rendered using the toastr adapter')
            //     ->flash()
            // ;

            // TODO: inform user about operation status/success.
            return $this->render('manage_keywords/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('manage_keywords/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function multicheck(): Response
    {
        $actionAttr = $this->stimulus->genActionAttr('multicheck', 'click');
        $targetAttr = $this->stimulus->genTargetAttr('multicheck');
        $attr = array_merge($actionAttr, $targetAttr);

        $form = $this->createFormBuilder()
            ->add('checkbox', CheckboxType::class, [
                'attr' => $attr,
                'required' => false,
                'label' => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                ],
            ])
            ->getForm()
        ;

        return $this->render('manage_keywords/multicheck.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function searchBar(): Response
    {
        $targetAttr = $this->stimulus->genTargetAttr('search');
        $attr = array_merge($targetAttr, ['placeholder' => 'Search']);

        $form = $this->createFormBuilder()
            ->add('query', SearchType::class, [
                'label' => 'Search',
                'attr' => $attr,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->getForm()
        ;

        return $this->render('manage_keywords/searchBar.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
