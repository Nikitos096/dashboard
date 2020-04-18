<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route(name="home", path="/")
     */
    public function homepage()
    {
        return new JsonResponse('Home page');
    }
}