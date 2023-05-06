<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'app_to_do')]
    public function index(Request $request): Response
    {

        $current_session = $request->getSession();

        if($current_session->has('todos')){

            $todos = $current_session->get('todos');

        }else{

            $todos = [
                "achat" => "acheter une clé USB",
                "cours" => "finaliser mon cours",
                "correction" => "corriger les examens"
            ];

        }

        $current_session->set('todos', $todos);

        return $this->render('to_do/index.html.twig');
    }
}
