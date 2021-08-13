<?php

namespace App\MessageHandler;

use App\Message\WebhookMessage;
use App\Service\RetailcrmService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class WebhookMessageHandler implements MessageHandlerInterface
{
    private $logger;
    private $retailcrmService;

    public function __invoke(WebhookMessage $message)
    {
        sleep(15);
        $this->logger->notice($message->getName());
        $this->retailcrmService->foo();
    }
    public function __construct(LoggerInterface $logger, RetailcrmService $retailcrmService)
    {
        $this->logger = $logger;
        $this->retailcrmService = $retailcrmService;
    }
}
