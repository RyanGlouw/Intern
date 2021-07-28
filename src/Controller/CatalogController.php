<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;

class CatalogController
{
    public function show()
    {
        return new Response(
            '<h1>Каталог</h1>'
        );
    }
}