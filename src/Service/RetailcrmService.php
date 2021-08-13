<?php


namespace App\Service;


use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RetailcrmService
{
    private $params;
    private $httpClient;
    private $logger;

    public function __construct(ParameterBagInterface $params, HttpClientInterface $httpClient, LoggerInterface $logger)
    {
        $this->params = $params;
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    public function foo()
    {
//        $out = file_get_contents('https://api.ipify.org');
        $this->logger->debug('Hello');
        $out = $this->httpClient->request('GET', 'https://api.ipify.org')->getContent();
        file_put_contents($this->params->get('foo_path') . time() . '.txt', $out);
    }
}