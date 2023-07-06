<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    #[IsGranted("ROLE_ADMIN", message: "Page non trouvée", statusCode: 404)]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }
}
