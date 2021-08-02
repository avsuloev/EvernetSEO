<?php

namespace App\Controller\Admin;

use App\Form\KwImportType;
use App\Service\FileUploader;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KeywordsImportController extends AbstractController
{
    public function uploadFileForm(): Response
    {
        $form = $this->createFormBuilder()
            ->add('elfinder', ElFinderType::class, [
                'instance' => 'form',
                'enable' => true,
            ])
            ->add('submit', SubmitType::class)
            ->getForm();

        return $this->render('admin/keywords_import/uploadFileForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{_locale<%app.supported_locales%>}/import-xslx', name: 'import_xslx', methods: 'POST')]
    public function uploadXslx(Request $request, FileUploader $fileUploader)
    {
        $form = $this->createForm(KwImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get(KwImportType::FIELD_NAME)->getData();
            $uploadDir = $this->getParameter('app.upload.import_dir');
            $newFilename = $fileUploader->setTargetDirectory($uploadDir)->upload($file);

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $uploadDir,
                    $newFilename,
                );
            } catch (FileException $e) {
                dd($e);
            }

//            $spreadsheet = IOFactory::load($uploadDir.$newFilename); // Here we are able to read from the excel file
//
//            $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line
//            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
//            dd($sheetData);

//            return $this->render('admin/keywords_import/uploadFileForm.html.twig', [
//                'form' => $form->createView(),
//            ]);

            return new JsonResponse([], 201);
        }

        return $this->render('admin/keywords_import/uploadFileForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
