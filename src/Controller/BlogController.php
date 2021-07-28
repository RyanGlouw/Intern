<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{

    #[Route('/blog', name: 'first')]
    public function list(){

        return new Response(
            '<html><body>' . __METHOD__ . '</body></html>'
        );
    }
}



//{
//    #[Route('/blog/{page}', name: 'first')]
//    public function list($page)
//    {
//        return new Response(
////            '<html><body>' . __METHOD__ . '</body></html>'
//        );
//    }
//    /**
//     * @Route("/blog/{page}", name="blog_show", requirements={"page"="\d+"})
//     */
//    public function show()
//    {
//
//        return new Response(
////            '<html><body>' . __METHOD__ . '</body></html>'
//        );
//    }
//}