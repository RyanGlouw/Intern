<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;

class AmocrmEnterController extends AbstractController
{
    #[Route('/amocrmenter', name: 'amocrmenter')]
    public function index(): Response
    {
        $post = 'ryantodd1176yandexru';
        $link = 'https://' . $post . '.amocrm.ru/oauth2/access_token';

        $data = [
            'client_id' => 'b5a8f60d-823d-48f7-9ed5-a77cab532a02',
            'client_secret' => 'R94TTt1HiW53ADBa8HFqOyFOvucZm1IOCkHSsypVF5GpAxz0AeudyA9sEN8k3iG6',
            'grant_type' => 'authorization_code',
            'code' => 'def50200f05219261736bf0500db75c30a1c73cfe62d6f00b49eddd136aee6f22224744b0da6d2e0b6718c1e1e21563df4668f9bd215719ee81876e6cd1884fcded81d1dd30c13181fe09b4490100189969e6e6e7b814a19d7809593f5f4b136f62c40588d668e7b68bd1c1a6df2110b5cc209681dbf0fc1ecc628c0f6216db825d1f23a0f6b4f3d5d4c25a111dbb5a9267c0204a8730717bd8d4bc15ddd8c6a91428e69dc216b88930b283f1cdcef4d530ad439d7a0b778171bbf728a56bad840751a4ded616d2ece22e819cf730a83f955d8cf7ea8ad0e9429044fc2ebf7d2aba6944998dec984adab006cc5dcb2ced04d30d3a799e7b47426be7501cd1f7e659b3b1adba0ba3530df50adb406e68ba3abf9d5ee4e2ca3245260aed60fb40e118408c024d853bbe351101cb7a3b9b8c01852a2448e1dbaffb00488167e54aaed6868739225781c669c07e02fa9cdb130d381369f2d68e20bf000797b87d7b0865d5b22152dc18944ccb4a94f4c44e706bed81385ed077da495aebd5fa19eb35ccc374dab61e4a49afc3646a864962396518e294d532d1d07278542d54da3a30352d58bcc9a6328de05b6d8fed26d788388e332bd5c4c326fb57280499f2b1fc5d9d8dcf80fb85dce977ae7008540482c77cf11',
            'redirect_uri' => 'https://cddc41996727.ngrok.io/amocrmenter',
        ];

        $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
        /** Устанавливаем необходимые опции для сеанса cURL  */
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-type: application/x-www-form-urlencoded']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        $code = (int)$code;
        if(curl_exec($curl) === false)
        {
            echo 'Ошибка curl: ' . curl_error($curl);
        }
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try
        {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        /**
         * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
         * нам придётся перевести ответ в формат, понятный PHP
         */
        $response = json_decode($out, true);

        $access_token = $response['access_token']; //Access токен
        $refresh_token = $response['refresh_token']; //Refresh токен
        $token_type = $response['token_type']; //Тип токена
        $expires_in = $response['expires_in']; //Через сколько действие токена истекает
        $file = 'file.txt';
        $current = file_get_contents($file);
        $current .= $access_token;
        file_put_contents($file, $current);
        return new JsonResponse($access_token);
//        $url = 'https://' . $post . '/api/v4/leads/';
//        $params = array(
//            'access_token' => $access_token,
//
//        );
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
//        $result = curl_exec($ch);
//        return new Response($result);
    }
    #[Route('/amoauth', name: 'amoauth')]
    public function auth() : Response
    {
        $subdomain = 'ryantodd1176yandexru';
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/contacts';
        $token = file_get_contents('file.txt');
        $access_token = $token;

        $headers = [
            'Authorization: Bearer ' . $access_token
        ];

        $curl = curl_init();

        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
        return new JsonResponse($out);
    }
}
