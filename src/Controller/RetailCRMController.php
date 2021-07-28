<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\b;

class RetailCRMController extends AbstractController
{
    #[Route('/retailcrm', name: 'retailcrm')]
    public function index(): Response
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://testcompany2.retailcrm.ru/api/v5/customers?apiKey=CEc8KkLUo8H9I7WGHTF4Rz7Z4qLG5pyq");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $result = json_decode($result, true);
        curl_close($curl);
        return $this->render("base.html.twig", array("result"=>$result));
//                return new JsonResponse($result["customers"]);

    }}
//    #[Route('/')]
//    public function show(){
//        return $this->render("base.html.twig",  $result);
//
//    }
//}
