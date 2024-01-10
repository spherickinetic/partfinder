<?php

namespace App\Controller;

use App\Entity\Part;
use App\Form\PartType;
use App\Controller\CrudController;
use App\Repository\PartRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

#[Route('/part')]
class PartController extends CrudController
{
    public function __construct(PartRepository $partRepository, EntityManagerInterface $entityManager)
    {
        $this->repo = $partRepository;
        $this->em = $entityManager;
        $this->twigPrefix = 'part';
        $this->redirectRouteName = 'app_part_index';
        $this->formType = PartType::class;
    }

    #[Route('/', name: 'app_part_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->indexAction();
    }

    #[Route('/new', name: 'app_part_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $this->entity = new Part();
        
        return $this->handleForm($request);
    }

    #[Route('/{id}', name: 'app_part_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $this->entity = $this->repo->find($id);

        return $this->showAction();
    }

    #[Route('/{id}/edit', name: 'app_part_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $this->entity = $this->repo->find($id);

        return $this->handleForm($request);
    }

    #[Route('/{id}', name: 'app_part_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        $this->entity = $this->repo->find($id);
        
        return $this->handleDelete($request);
    }
}
