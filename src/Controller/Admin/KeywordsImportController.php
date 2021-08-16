<?php

namespace App\Controller\Admin;

use App\Entity\Keyword;
use App\Entity\KeywordGroup;
use App\Entity\Project;
use App\Form\KwImportType;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use App\Service\KeywordsImportService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class KeywordsImportController extends AbstractController
{
    public function __construct(
        private SweetAlertFactory $flasher,
        private TranslatorInterface $translator,
        private KeywordsImportService $kwImporter,
        private ProjectRepository $projectRepo,
        private EntityManagerInterface $em,
    ) {
    }

//    public function kwImportForm(): Response
//    {
//        $form = $this->createFormBuilder()
//            ->add('elfinder', ElFinderType::class, [
//                'instance' => 'form',
//                'enable' => true,
//            ])
//            ->add('submit', SubmitType::class)
//            ->getForm();
//
//        return $this->render('admin/keywords_import/kwImportForm.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }

    #[Route(path: '/{_locale<%app.supported_locales%>}/import-xslx', name: 'import_xslx', methods: 'POST')]
    public function uploadXslx(Request $request, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(KwImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get(KwImportType::FIELD_NAME)->getData();
            $projectId = $form->get('project')->getData();
            $uploadDir = $this->getParameter('app.upload.import_dir');
            $newFilename = $fileUploader->setTargetDirectory($uploadDir)->upload($file);

            $project = $this->projectRepo->findOneBy(['id' => $projectId]);
            if (null === $project) {
                // todo
                throw new \Exception();
            }
            $this->kwImporter
                ->setProject($project)
                ->importFromXslx("$uploadDir/$newFilename")
                ->toOrm()
            ;

            $groups = $this->kwImporter->getKwGroups();
            $keywords = $this->kwImporter->getKeywords();

            $this
                ->doctrineBulkInsert($groups, KeywordGroup::class)
                // ->doctrineBulkInsert($keywords, Keyword::class)
            ;

            // dd($groups);
            // $sortedGroups = [];
            // foreach ($groups as $group) {
            //     if ('Говядина' === $group->getName()) {
            //         $sortedGroups[] = $group;
            //     }
            // }
            // dd($sortedGroups);

            // $this->flasher->addError('Upload error!');

            return $this->render('admin/keywords_import/kwImportForm.html.twig', [
                'form' => $form->createView(),
            ]);

            $this->flasher->addSuccess('Data has been uploaded successfully!');

            return new JsonResponse([], 201);
        }

        return $this->render('admin/keywords_import/kwImportForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function doctrineBulkInsert(
        ArrayCollection $collection,
        string $class,
    ): self {
        $em = $this->em;
        $batchSize = 20;
        // $parentGroupIds = [];
        // $projectId = null;
        // $doFlush = false;

        foreach ($collection as $key => $value) {
            // if ($doFlush) {
            //     foreach ($parentGroupIds as $parentId) {
            //         $parent = $em->getRepository(KeywordGroup::class)->find($parentId);
            //         $em->persist($parent);
            //     }
            //     $project = $em->getRepository(Project::class)->find($projectId);
            //     $em->persist($project);
            // }
            $em->persist($value);

            // fixme: chunking, done only by limit, is a source of dupe entries.
            //  consider [ https://stackoverflow.com/questions/36390063/zend-framework-2-doctrine-2-bulk-operations-and-events-triggering ]
//            if (0 === ($key % $batchSize)) {
//                // $parentGroupIds[] = $value->getId();
//                // $projectId = $value->getProject()->getId();
//                // $depth = $value->getLevel();
//                // for ($i = 0; $i < $depth; $i++) {
//                //     $parentGroupIds[] = $value->getSupergroup()->getId();
//                // }
//                // $doFlush = true;
//
//                $em->flush();
//                // $em->detach();
//                $em->clear();
//            }
        }
        $em->flush(); // Persist objects that did not make up an entire batch
        $em->clear();

        return $this;
    }
}
