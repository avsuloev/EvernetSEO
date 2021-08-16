<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectReportController extends AbstractController
{
    private ?Project $project = null;

    public function __construct(
        private AdminContextProvider $adminContextProvider,
        private ProjectRepository $projectRepo,
    ) {
    }

    public function index(): Response
    {
        // MyBundle:Foo:bar.html.twig
        $response = new Response();
        $response->setContent(
            $this->prepareReportView()
            .$this->renderView('admin/project_report/_download_pdf_btn.html.twig')
        );

        return $response;
    }

    private function prepareReportView(): string
    {
        // $eaContext = $this->adminContextProvider->getContext();
        $project = $this->project ?? $this->projectRepo->findOneBy([], ['id' => 'desc']);

        return $this->renderView('admin/project_report/index.html.twig', [
            'project_name' => null !== $project ? $project->getCmsTitle() : 'No projects in DB',
            'project_report' => 'No reports',
        ]);
    }

    public function projectEntityForm(): Response
    {
        $form = $this->createFormBuilder()
            ->add('query', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'cmsTitle',
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Сформировать отчёт'])
            ->getForm()
        ;

        return $this->render('admin/project_report/projectEntityForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function ymReportEntityForm(): Response
    {
        return $this->render('');
    }

    #[Route('/{_locale<%app.supported_locales%>}/download-report', name: 'download_project_report')]
    public function genPdf(Pdf $knpSnappyPdf): PdfResponse
    {
        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($this->prepareReportView(), ['encoding' => 'utf-8']),
            'report.pdf'
        );
    }
}
