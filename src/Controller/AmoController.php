<?php

namespace App\Controller;

use App\Service\AmocrmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/amo', name: 'amo')]
class AmoController extends AbstractController
{
    #[Route('/token', name: 'token')]
    public function getToken(ParameterBagInterface $param, Request $request, AmocrmService $amocrmService): Response
    {

        $code = $request->get('code');
        if ($code)
        {
//            получить refresh token и сохранить
            $amocrmService->getToken($code);
            return new Response('Done');
        }
        $url = 'https://www.amocrm.ru/oauth?client_id=' . $param->get('amocrm.client_id');
        return $this->redirect($url, 301);

    }
    #[Route('/get-leads', name: 'get-leads')]
    public function getLeads(ParameterBagInterface $param, Request $request, AmocrmService $amocrmService)
    {
        $leads = $amocrmService->getLeads();
        return new JsonResponse($leads);
    }
    #[Route('/get-contacts', name: 'get-contacts')]
    public function getContacts(ParameterBagInterface $param, Request $request, AmocrmService $amocrmService)
    {
        $contacts = $amocrmService->getContacts();
        return new JsonResponse($contacts);
    }
}
