<?php


namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AmocrmService
{
    private $params;
    private $httpClient;
    private $baseUrl;

    public function __construct(ParameterBagInterface $params, HttpClientInterface $httpClient)
    {
        $this->params = $params;
        $this->httpClient = $httpClient;
        $sumdomain = $this->params->get('amocrm.subdomain');
        $this->baseUrl = 'https://' . $sumdomain . '.amocrm.ru/';
        $this->checkTokens();
    }

    public function getToken($code)
    {
        $url = $this->baseUrl . 'oauth2/access_token';
        $data = [
            'client_id' => $this->params->get('amocrm.client_id'),
            'client_secret' => $this->params->get('amocrm.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->params->get('amocrm.redirect_uri'),
        ];

        $postData = json_encode($data);
        $response = $this->httpClient->request('POST', $url, [
            'headers' => array('Content-Type:application/json'),
            'body' => $postData,
        ]);

        file_put_contents($this->params->get('amocrm.token_file'), $response->getContent());

    }

    public function request($path, $method = 'GET', $body = [])
    {
        $url = $this->baseUrl . 'api/v4/' . $path;
        $tokens_json = file_get_contents($this->params->get('amocrm.token_file'));
        $tokens = json_decode($tokens_json, true);
        $response = $this->httpClient->request('GET', $url, [
            'headers' => [
                'Authorization: ' . $tokens['token_type'] . ' ' . $tokens['access_token']
            ]
        ]);
        return $response->toArray();
    }

    public function getLeads()
    {
        return $this->request('leads');
    }

    public function getContacts()
    {
        return $this->request('contacts');

    }

    public function getEmail($email)
    {
        $url = $this->baseUrl . "/api/v4/contacts?query={$email}";

        return $this->request($url);
    }

    public function contact()

    public function addContact($name, $phone, $email, $customFields = []): int
    {
        $response = $this->getEmail($email);
        if ($response) {
            return json_decode($response, true)["_embedded"]["contacts"][0]["id"];
        } else {
            $url = $this->baseUrl . "/api/v4/contacts";
            $info = [["first_name" => $name, "custom_fields_values" => [[
                "field_id" => 3340577,
                "values" => [[
                    "value" => $phone,
                    "enum_code" => "WORK"
                ]]
            ]
            ]
            ]];
            return $this->httpClient->request($url, $info);
        }
    }

    public function addLead($name, $statusId, $price, $customFields = []): int
    {

    }

    public function lead($leadId, $contactId)
    {

    }

    public function refreshToken()
    {
        $tokensJson = file_get_contents($this->params->get('amocrm.token_file'));
        $tokens = json_decode($tokensJson, true);
        $url = $this->baseUrl . 'oauth2/access_token';
        $data = [
            'client_id' => $this->params->get('amocrm.client_id'),
            'client_secret' => $this->params->get('amocrm.client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $tokens['refresh_token'],
            'redirect_uri' => $this->params->get('amocrm.redirect_uri'),
        ];

        $postData = json_encode($data);
        $response = $this->httpClient->request('POST', $url, [
            'headers' => array('Content-Type:application/json'),
            'body' => $postData,
        ]);

        file_put_contents($this->params->get('amocrm.token_file'), $response->getContent());

    }

    public function checkTokens()
    {
        if (file_exists($this->params->get('amocrm.token_file'))) {

            $tokensJson = file_get_contents($this->params->get('amocrm.token_file'));
            $tokens = json_decode($tokensJson, true);
            $timeNow = time();
            $expiresIn = $tokens['expires_in'];
            $timeCreate = filemtime($this->params->get('amocrm.token_file'));
            $expiresAt = $timeCreate + $expiresIn;

            if ($timeNow > $expiresAt) {
                $this->refreshToken();
            }
        }

    }
}