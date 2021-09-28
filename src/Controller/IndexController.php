<?php

namespace App\Controller;

use App\Controller\Mercure\CookieGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class IndexController extends AbstractController {
    /**
     * @Route("/chat", name="chat")
     */
    public function __invoke(CookieGenerator $cookieGenerator):Response {
        $response = $this->render('mercure/index.html.twig', []);
        $response->headers->setCookie($cookieGenerator->generate());

        return $response;
    }
}