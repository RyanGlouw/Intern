<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CreateOrderController extends AbstractController
{
    #[Route('/create_order', name: 'create_order')]
    public function index(): Response
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://testcompany2.retailcrm.ru/api/v5/orders/create?apiKey=CEc8KkLUo8H9I7WGHTF4Rz7Z4qLG5pyq");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $requestBody = [
            "order" => json_encode(["firstName" => "testov4", "lastName" => "testovich4", "phone" => "+7999999999", "email" => '11@mail.ru']),
        ];
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestBody));
//        $result = json_decode($result, true);
        $output = curl_exec($curl);
        curl_close($curl);
        return var_dump($curl);
//    return new JsonResponse(json_decode($output));

    }
}
