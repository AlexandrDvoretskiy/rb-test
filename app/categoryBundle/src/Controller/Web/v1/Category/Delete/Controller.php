<?php

namespace CategoryBundle\Controller\Web\v1\Category\Delete;

use CategoryBundle\Domain\Service\CategoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {
    }

    #[Route("category-api/v1/delete/{id}", name: "category_delete", requirements: ["id" => "\d+"], methods: ["DELETE"])]
    public function delete(int $id): Response
    {
        return new JsonResponse([
            "success" => $this->categoryService->delete($id),
        ]);
    }
}