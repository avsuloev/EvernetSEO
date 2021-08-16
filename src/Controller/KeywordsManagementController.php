<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\KwManageFieldsetType;
use App\Form\KwManageMulticheckType;
use App\Form\KwManageProjectType;
use App\Form\KwManageSearchType;
use App\Model\KwCollectionModel;
use App\Repository\KeywordRepository;
use App\Service\AuthenticatedClientService;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KeywordsManagementController extends AbstractController
{
    public const STIMULUS_CTRL = 'keywords-management';

    // private StimulusAttributesService $stimulus;
    private ?Project $project = null;

    public function __construct(
        private AuthenticatedClientService $authenticatedClient,
        private SweetAlertFactory $flasher,
    ) {
        // $this->stimulus = new StimulusAttributesService(self::STIMULUS_CTRL);
    }

    private function setProject(
        ?Project $project = null,
    ) {
        // make sure the user is authenticated first
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //todo: handle Exceptions better.
        try {
            $projects = $this->authenticatedClient->getActiveProjects();
            if (null !== $project) {
                $this->project = $projects->contains($project)
                    ? $project
                    : throw new \Exception("Your account doesn't have such active projects.")
                ;

                return $this;
            }
            $this->project = $projects->last();
        } catch (\Exception $e) {
            $this->flasher->addError($e->getMessage());
        }

        return $this;
    }

    /**
     * @throws \Exception
     */
    #[Route(path: '/{_locale<%app.supported_locales%>}/manage-keywords', name: 'manage_keywords')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        KeywordRepository $kwRepository,
        PaginatorInterface $paginator,
    ): Response {
        /** @var Project $project */
        $project = $request->request->get('project');
        $this->setProject($project);
        $project = $this->project;
        $projectName = $project->getCmsTitle();

        $q = $request->query->get('q');
        if ($q) {
            $queryBuilder = $kwRepository->getWithSearchQueryBuilder($q);
        } else {
            $queryBuilder = $kwRepository->getWithByProjectQueryBuilder($projectName);
        }
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1) /* page number */,
            15, /* limit per page */
        );
        $pagination->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
            'size' => 'large', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            // 'span_class' => 'whatever',
        ]);

        $kwCollection = new KwCollectionModel();
        $keywords = $pagination->getItems();
        $pagination->setItems([]); # unsetting pagination AFTER getting items[Keyword] for form
        foreach ($keywords as $keyword) {
            $kwCollection->addKeyword($keyword);
        }

        $form = $this->createForm(KwManageFieldsetType::class, $kwCollection);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$kwCollection` variable has also been updated
            /** @var KwCollectionModel $kwCollection */
            $kwCollection = $form->getData();
            foreach ($kwCollection->getKeywords() as $keyword) {
                $em->persist($keyword);
            }
            $em->flush();

            return $this->render('manage_keywords/index.html.twig', [
                'form' => $form->createView(),
                'project_name' => $projectName,
                'pagination' => $pagination,
            ]);
        }

        return $this->render('manage_keywords/index.html.twig', [
            'form' => $form->createView(),
            'project_name' => $projectName,
            'pagination' => $pagination,
        ]);
    }

    public function multicheck(): Response
    {
        $form = $this->createForm(KwManageMulticheckType::class);

        return $this->render('manage_keywords/multicheck.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function projectEntityForm(Request $request): Response
    {
        $form = $this->createForm(KwManageProjectType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->setData();

            return $this->render('admin/project_report/projectEntityForm.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('admin/project_report/projectEntityForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function searchBar(): Response
    {
        $form = $this->createForm(KwManageSearchType::class);

        return $this->render('manage_keywords/searchBar.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
