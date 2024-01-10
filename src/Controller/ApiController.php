<?php

namespace App\Controller;

use App\Controller\TokenAuthenticatedController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\PartRepository;

#[Route('/api')]
class ApiController implements TokenAuthenticatedController
{
    public SerializerInterface $serializer;
    public ValidatorInterface $validator;
    public LoggerInterface $logger;
    public PartRepository $partRepo;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        LoggerInterface $logger,
        PartRepository $partRepo
    )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->logger = $logger;
        $this->partRepo = $partRepo;
    }

    #[Route('/part/all', name: 'app_api_part_all', methods: ['POST'])]
    public function index(Request $request): Response
    {
        try
        {
            $this->logger->info('Parts API request received - ' . $request->getContent());

            $response = $this->partRepo->findAll();
            $responseCode = 200;
        }
        catch(\Throwable $error)
        {
            $this->logger->error('Error - ' .  $error->getMessage());
            $response = ['message' => 'Error! - Contact support'];
            $responseCode = 500;
        }

        // return new Response($this->serializer->serialize($response, 'json', ['ignored_attributes' => ['id','vendorParts']]), $responseCode, ['Content-Type' => 'application/json']);
        return new Response($this->serializer->serialize(
            $response,
            'json',
            [
                'enable_max_depth' => true,
                'circular_reference_handler' => function ($object) {
                    switch($object){
                        case $object instanceof \App\Entity\VendorPart:
                            return null;
                        }
                    return $object->getId();
                },
                'ignored_attributes' => ['id', 'vendorParts']
            ]),
        $responseCode, ['Content-Type' => 'application/json']);
    }
}
