<?php

namespace App\Controller;

use App\Controller\CrudController;
use App\Entity\Vendor;
use App\Form\VendorType;
use App\Repository\VendorRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendor')]
class VendorController extends CrudController
{
    public function __construct(VendorRepository $vendorRepository, EntityManagerInterface $entityManager)
    {
        $this->repo = $vendorRepository;
        $this->em = $entityManager;
        $this->twigPrefix = 'vendor';
        $this->redirectRouteName = 'app_vendor_index';
        $this->formType = VendorType::class;
    }

    #[Route('/', name: 'app_vendor_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->indexAction();
    }

    #[Route('/new', name: 'app_vendor_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $this->entity = new Vendor();
        
        return $this->handleForm($request);
    }

    #[Route('/{id}', name: 'app_vendor_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $this->entity = $this->repo->find($id);

        return $this->showAction();
    }

    #[Route('/{id}/edit', name: 'app_vendor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $this->entity = $this->repo->find($id);

        return $this->handleForm($request);

    }

    #[Route('/{id}', name: 'app_vendor_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        $this->entity = $this->repo->find($id);
        
        return $this->handleDelete($request);
    }
}
