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
            'client_secret' => 'mfLUHZJwSc5QuFEesCqgzYbfOOgiM7d5tgOi2OPhhS6Fa68xrbdTCqcBDsiTFNCF',
            'grant_type' => 'authorization_code',
            'code' => 'def502004e8e1a9811b41d659eb2e3d4cecafd25ab342b8410fa9a7a8904fa647089968484bb13de580a6722b1615bf6b6b85cd3bb9059b7160345e2c66f0e7e19a283932cbc8712ec92966a5b8cd667e485e88446b92ad5de02b1a6f94050b600080cea90705a8d7588b26f1ba31878bd96dcc7fe6ed768d0d696ff9ec968fe0a53b9ffacb9e59ccb8244810167fceec76dfd8a054b95ff0a38e927cfc50be1574905d64298b3482d903a0620b353760315809753bf28919ec965f226cef2070174ed03c05a6a7957a6fbd74d5b275b4b5f82ef9237b6f59d32955423d1cbb1d2e91a413f809bf4d2beb95b6df9a60e03adef0d21f8dab9df94144ddd3b27b679e6d1191be25de9d1b642698442a2bb41b0b6a3d2250238e6ca73f336737c82991925cce348c34fa6664ffa44c77e16b97d0c9be1fc3dccabb1cb8d57a582f735ce22754ea0ecba286b4e9dc1b2e2d493e5a7efb28b19a23fccbfe78fb1c07341dc135af24cd35ac850a304fdb1a5955ffab8edd8317ced83775443785a547a26fe9786369d0ec93d8cf0c1d68f1b6d305e675294b46f190976b8e4a6787b5ff6f4ad57ffd41a9ed5f53375c74022ea2bcab113ff365497e3aeddf6a66215ed1e3c97c6a40b8b19f74a67c30de2ada551ab5b3f',
            'redirect_uri' => 'https://ceb5337a522f.ngrok.io/amocrmenter',
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
