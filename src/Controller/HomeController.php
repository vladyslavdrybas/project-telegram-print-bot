<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/", name="app_home", methods={"GET", "OPTIONS", "HEAD"})
     * @return Response
     */
    public function home(): Response
    {
        return new Response('Hello!');
    }

    /**
     * @Route("/healthcare", name="app_healthcare", methods={"GET", "OPTIONS", "HEAD"})
     * @return Response
     */
    public function healthcare(): Response
    {
        return new Response('Ok');
    }
}
