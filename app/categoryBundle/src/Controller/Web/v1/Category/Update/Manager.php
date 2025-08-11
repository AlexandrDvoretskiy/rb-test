<?php

namespace CategoryBundle\Controller\Web\v1\Category\Update;

use CategoryBundle\Domain\Service\CategoryService;
use CategoryBundle\Controller\Web\v1\Category\Update\Input\UpdateCategoryDTO as ControllerCategoryDTO;
use CategoryBundle\Domain\DTO\UpdateCategoryDTO as DomainCategoryDTO;
use Symfony\Component\Serializer\SerializerInterface;


class Manager
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function update(int $id, ControllerCategoryDTO $controllerCategoryDTO): array
    {
        $domainCategoryDTO = new DomainCategoryDTO(
            $controllerCategoryDTO->title,
            $controllerCategoryDTO->sort,
        );

        $res = $this->categoryService->update($id, $domainCategoryDTO);

        return ["success" => $res];
    }
}