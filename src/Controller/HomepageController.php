<?php

namespace App\Controller;

use App\Contracts\Service\API\YandexMetrikaInterface;
use App\Service\API\YandexMetrika;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(YandexMetrika $metrika): Response
    {
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'YM' => $metrika->getVisitors(),
        ]);
    }
}
