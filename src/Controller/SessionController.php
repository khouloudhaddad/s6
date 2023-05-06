<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'session')]
    public function index(Request $request): Response
    {
        $session = $request->getSession(); //session_start()

        if($session->has('nomderDeVistes')){
            $nomderDeVistes = $session->get('nomderDeVistes') +1;
        } else {
            $nomderDeVistes = 1;
        }

        $session->set('nomderDeVistes', $nomderDeVistes);

        return $this->render('session/index.html.twig');
    }
}
