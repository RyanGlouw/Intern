<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/blog', name: 'first')]
    public function list($page = 1)
    {

        return new Response(
            '<html><body>' . __METHOD__ .  $page . '</body></html>'
        );
    }
}
