<?php

namespace CategoryBundle\Controller\Web\v1\Category\Get;

use CategoryBundle\Domain\Service\CategoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    #[Route('category-api/v1/get/{id}', name: 'category_get', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function get(int $id): Response
    {
        return new JsonResponse($this->categoryService->get($id));
    }
}