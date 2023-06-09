<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class ToDoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response
    {

        $current_session = $request->getSession();

        if (!$current_session->has('todos')) {

            $todos = [
                "achat" => "acheter une clé USB",
                "cours" => "finaliser mon cours",
                "correction" => "corriger les examens"
            ];

            $current_session->set('todos', $todos);
            $this->addFlash('info', "La liste des todo vient d'être initialisée");
        }


        return $this->render('to_do/index.html.twig');
    }

    //Add a Todo
    #[Route(
        '/add/{name}/{content}', 
        name: 'todo.add',
        defaults: ['content' => "sf6"]
        )]
    public function addToDo(Request $request, $name, $content): RedirectResponse
    {

        $session = $request->getSession();

        if ($session->has('todos')) {

            $todos = $session->get('todos');
            if(isset($todos[$name])){
                $this->addFlash('danger', "La liste des todo contient ce ToDo d'id $name");
            }else{
                $todos[$name] = $content;
                $session->set('todos', $todos);

                $this->addFlash('success', "le ToDo d'id $name a été ajouté avec succès");
            }
        } else {
            $this->addFlash('danger', "La liste des todo n'est pas encore initialisée");
        }

        return $this->redirectToRoute('todo');
    }

    //Update a Todo
    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateToDo(Request $request, $name, $content): RedirectResponse
    {

        $session = $request->getSession();

        if ($session->has('todos')) {

            $todos = $session->get('todos');
            if(!isset($todos[$name])){
                $this->addFlash('danger', "La liste des todo ne contient pas ce ToDo d'id $name");
            }else{
                $todos[$name] = $content;
                $session->set('todos', $todos);

                $this->addFlash('success', "le ToDo d'id $name a été mis à jour avec succès");
            }
        } else {
            $this->addFlash('danger', "La liste des todo n'est pas encore initialisée");
        }

        return $this->redirectToRoute('todo');
    }

    //Delete a Todo
    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteToDo(Request $request, $name): RedirectResponse
    {

        $session = $request->getSession();

        if ($session->has('todos')) {

            $todos = $session->get('todos');
            if(!isset($todos[$name])){
                $this->addFlash('danger', "La liste des todo ne contient pas ce ToDo d'id $name");
            }else{
                unset($todos[$name]);
                $session->set('todos', $todos);

                $this->addFlash('success', "le ToDo d'id $name a été supprimé avec succès");
            }
        } else {
            $this->addFlash('danger', "La liste des todo n'est pas encore initialisée");
        }

        return $this->redirectToRoute('todo');
    }

    //Reset Todos
    #[Route('/reset', name: 'todo.reset')]
    public function resetToDo(Request $request): RedirectResponse
    {

        $session = $request->getSession();

        $session->remove('todos');

        return $this->redirectToRoute('todo');
    }

}
