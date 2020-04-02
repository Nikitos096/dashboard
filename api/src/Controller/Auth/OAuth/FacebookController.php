<?php

declare(strict_types=1);

namespace App\Controller\Auth\OAuth;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FacebookController extends AbstractController
{
    /**
     * @param ClientRegistry $clientRegistry
     * @return RedirectResponse
     * @Route("/connect/facebook", name="oauth.facebook")
     */
    public function connect(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('facebook_main')
            ->redirect(['public_profile'], []);
    }

    /**
     * @param Request $request
     * @param ClientRegistry $clientRegistry
     * @Route("/connect/facebook/check", name="oauth.facebook_check")
     * @return RedirectResponse
     */
    public function check(Request $request, ClientRegistry $clientRegistry)
    {
        return $this->redirect('/');
    }
}