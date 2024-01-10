<?php

namespace App\Controller;

use App\Controller\TokenAuthenticatedController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PartNumberFinder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class QueryController implements TokenAuthenticatedController
{
    public SerializerInterface $serializer;
    public ValidatorInterface $validator;
    public LoggerInterface $logger;
    public PartNumberFinder $partNumberFinder;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        LoggerInterface $logger,
        PartNumberFinder $partNumberFinder
    )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->logger = $logger;
        $this->partNumberFinder = $partNumberFinder;
    }

    #[Route('/query', name: 'app_query', methods: ['POST'])]
    public function index(Request $request): Response
    {
        try
        {
            $this->logger->info('Query request received - ' . $request->getContent());

            $partNumberDTO = $this->serializer->deserialize($request->getContent(), 'App\DTO\PartNumberQuery' ,'json');

            $errors = $this->validator->validate($partNumberDTO);

            if (count($errors) > 0) {
                $this->logger->error($errors[0]->getPropertyPath() . ' - ' . $errors[0]->getMessage());
                $response = ['message' => 'There is an error with the payload'];
                $responseCode = 500;
            }
            else
            {
                $response = $this->partNumberFinder->find($partNumberDTO);
                $responseCode = 200;
            }
        }
        catch(\Throwable $error)
        {
            $this->logger->error('Error - ' .  $error->getMessage());
            $response = ['message' => 'Error! - Contact support'];
            $responseCode = 500;
        }

        return new Response($this->serializer->serialize($response, 'json'), $responseCode, ['Content-Type' => 'application/json']);
    }
}
