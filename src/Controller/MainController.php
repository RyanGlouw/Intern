<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/main', name: 'main_')]
class MainController extends AbstractController
{
    #[Route('/func/{fix}', name: 'main')]
    public function index($fix, Request $request): Response
    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/MainController.php',
//        ]);
//        return new JsonResponse([]);
        $var = [
            'message' => $fix,
            'req' => $request->query->get('name')
        ];
        return new JsonResponse($var);
//        return new Response(json_encode($var));
    }


}
