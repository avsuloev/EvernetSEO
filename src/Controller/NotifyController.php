<?php

namespace App\Controller;

use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NotifyController extends AbstractController
{
    public function flasher(SweetAlertFactory $flasher): Response
    {
        $flasher->addSuccess('Data has been saved successfully!');

        return $this->render('notify/index.html.twig', [
        ]);
    }
}
