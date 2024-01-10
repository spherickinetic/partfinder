<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class CrudController extends AbstractController
{
    public $repo;
    public EntityManagerInterface $em;
    public string $twigPrefix;
    public string $redirectRouteName;
    public string $formType;
    public $entity;

    abstract public function index(): Response;
    abstract public function new(Request $request): Response;
    abstract public function show(int $id): Response;
    abstract public function edit(Request $request, int $id): Response;
    abstract public function delete(Request $request, int $id): Response;

    public function indexAction(): Response
    {
        return $this->render('/crud/index.html.twig', [
            'items' => $this->repo->findAll(),
            'showPath' => 'app_' . $this->twigPrefix . '_show',
            'newPath' => 'app_' . $this->twigPrefix . '_new'
        ]);
    }

    public function showAction(): Response
    {
        return $this->render('/crud/show.html.twig', [
            'item' => $this->entity,
            'editPath' => 'app_' . $this->twigPrefix . '_edit',
            'deletePath' => 'app_' . $this->twigPrefix . '_delete',
        ]);
    }

    public function handleForm(Request $request): Response
    {
        $form = $this->createForm($this->formType, $this->entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($this->entity);
            $this->em->flush();

            $this->addFlash(
                'notice',
                'Success!'
            );

            return $this->redirectToRoute($this->redirectRouteName, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/new.html.twig', [
            'entity' => $this->entity,
            'form' => $form
        ]);
    }

    public function handleDelete(Request $request): Response
    {
        try
        {
            if ($this->isCsrfTokenValid('delete' . $this->entity->getId(), $request->request->get('_token'))) {
                $this->em->remove($this->entity);
                $this->em->flush();

                $this->addFlash(
                    'notice',
                    'Success!'
                );
            }
        }
        catch(\Throwable $error)
        {
            $this->addFlash(
                'error',
                'The item was not deleted, there was an error!  This item is probably associated with a vendor part number'
            );
        }

        return $this->redirectToRoute($this->redirectRouteName, [], Response::HTTP_SEE_OTHER);
    }
}