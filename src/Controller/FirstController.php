<?php

namespace App\Controller;

use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')] //attribute not an annotation
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }

    #[Route(
        '/multi/{entier1<\d+>}/{entier2<\d+>}',
        name: 'multiplication',
        
        )] //attribute not an annotation
    public function multiplication($entier1, $entier2): Response
    {
        $result = $entier1 * $entier2;
        return new Response("<h1>$result</h1>");
    }
}
