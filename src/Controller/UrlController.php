<?php

namespace App\Controller;

use App\Message\WebhookMessage;
use App\Service\RetailcrmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
    #[Route('/url', name: 'url')]
    public function index(RetailcrmService $retailcrmService, MessageBusInterface $bus): Response
    {
//        $retailcrmService->foo();
        $webhookMessage = new WebhookMessage('Hi');
        $bus->dispatch($webhookMessage);
        return $this->render('url/index.html.twig', [
            'controller_name' => 'UrlController',
        ]);
    }
}
