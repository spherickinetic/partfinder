<?php

namespace App\Controller;

use App\Entity\VendorPart;
use App\Form\VendorPartType;
use App\Controller\CrudController;
use App\Repository\VendorPartRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendorpart')]
class VendorPartController extends CrudController
{
    public function __construct(VendorPartRepository $vendorPartRepository, EntityManagerInterface $entityManager)
    {
        $this->repo = $vendorPartRepository;
        $this->em = $entityManager;
        $this->twigPrefix = 'vendor_part';
        $this->redirectRouteName = 'app_vendor_part_index';
        $this->formType = VendorPartType::class;
    }

    #[Route('/', name: 'app_vendor_part_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->indexAction();
    }

    #[Route('/new', name: 'app_vendor_part_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $this->entity = new VendorPart();
        
        return $this->handleForm($request);
    }

    #[Route('/{id}', name: 'app_vendor_part_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $this->entity = $this->repo->find($id);

        return $this->showAction();
    }

    #[Route('/{id}/edit', name: 'app_vendor_part_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $this->entity = $this->repo->find($id);

        return $this->handleForm($request);
    }

    #[Route('/{id}', name: 'app_vendor_part_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        $this->entity = $this->repo->find($id);
        
        return $this->handleDelete($request);
    }
}
