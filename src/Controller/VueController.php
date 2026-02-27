<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VueController extends AbstractController
{
    #[Route('/{vueRoute}', name: 'app_vue', requirements: ['vueRoute' => '^(?!api|_(profiler|wdt)).*'], defaults: ['vueRoute' => ''])]
    public function index(): Response
    {
        return $this->render('spa.html.twig');
    }
}
