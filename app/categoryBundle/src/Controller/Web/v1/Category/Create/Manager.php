<?php

namespace CategoryBundle\Controller\Web\v1\Category\Create;

use CategoryBundle\Domain\Service\CategoryService;
use CategoryBundle\Controller\Web\v1\Category\Create\Input\CreateCategoryDTO as ControllerCategoryDTO;
use CategoryBundle\Domain\DTO\CreateCategoryDTO as DomainCategoryDTO;


class Manager
{
    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function create(ControllerCategoryDTO $controllerCategoryDTO): array
    {
        $domainCategoryDTO = new DomainCategoryDTO(
            $controllerCategoryDTO->title,
            $controllerCategoryDTO->sort,
        );

        $id = $this->categoryService->create($domainCategoryDTO);

        return is_int($id) ? ["success" => "true", "id" => $id] : ["success" => "false"];
    }
}