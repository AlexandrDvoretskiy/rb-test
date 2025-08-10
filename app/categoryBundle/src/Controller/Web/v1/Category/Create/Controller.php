<?php

namespace CategoryBundle\Controller\Web\v1\Category\Create;

use CategoryBundle\Controller\Web\v1\Category\Create\Input\CreateCategoryDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[Route("category-api/v1/create", name: "category_create", methods: ["POST"])]
    public function __invoke(#[MapRequestPayload] CreateCategoryDTO $categoryDTO): Response
    {
        return new JsonResponse($this->manager->create($categoryDTO));
    }
}