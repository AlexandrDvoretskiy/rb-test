<?php

namespace CategoryBundle\Controller\Web\v1\Category\Update;

use CategoryBundle\Controller\Web\v1\Category\Update\Input\UpdateCategoryDTO;
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

    #[Route("category-api/v1/update/{id}", name: "category_update", methods: ["PUT", "PATCH"])]
    public function __invoke(int $id, #[MapRequestPayload] UpdateCategoryDTO $categoryDTO): Response
    {
        return new JsonResponse($this->manager->update($id, $categoryDTO));
    }
}