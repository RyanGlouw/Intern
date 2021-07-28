<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lead;

class AmoCRMController extends AbstractController
{
    #[Route('/amocrm', name: 'amocrm')]
    public function index(Request $request): Response
    {
//        $leads = $request->request->get('leads');
//        $name = $leads['update'][0]['name'];
//        return new Response($name);
        $leads = $request->request->get( 'leads');
        $name = $leads['update'][0]['name'];
        $LeadId = $leads['update'][0]['id'];

        $entityManager = $this->getDoctrine()->getManager();
        $Lead = new Lead;
        $Lead->setLeadId($LeadId);
        $Lead->setName($name);

        $entityManager->persist($Lead);
        $entityManager->flush();

        return new Response();
    }
}
//    #[Route('/amocrm', name: 'amocrm')]
//    public function index(Request $request): Response
//    {
//        $account = $request->request->get('account');
//        $name = $account['id'];
//        return new Response($name);
//    }
//}
