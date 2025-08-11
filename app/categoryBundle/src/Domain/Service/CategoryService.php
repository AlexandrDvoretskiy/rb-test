<?php

namespace CategoryBundle\Domain\Service;

use App\Service\BookService;
use CategoryBundle\Domain\DTO\CreateCategoryDTO;
use CategoryBundle\Domain\DTO\UpdateCategoryDTO;
use CategoryBundle\Domain\Entity\Category;
use CategoryBundle\Infrastructure\Repository\CategoryRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly BookService $bookService,
    ){
    }

    public function create(CreateCategoryDTO $createCategoryDTO): int
    {
        $category = new Category(
            $createCategoryDTO->title,
            $createCategoryDTO->sort
        );

        return $this->categoryRepository->create($category);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function get(int $id): array
    {
        $category = $this->categoryRepository->findById($id);

        return ($category instanceof Category) ? $category->toArray() : [];
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(int $id, UpdateCategoryDTO $updateCategoryDTO): bool
    {
        $category = $this->categoryRepository->findById($id);
        if ($category instanceof Category) {
            return $this->categoryRepository->update($id, $updateCategoryDTO);
        }

        return false;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(int $id): bool
    {
        $category = $this->categoryRepository->findById($id);

        if ($category instanceof Category) {
            $hasBook = $this->bookService->hasBooks($id);
            if (!$hasBook) {
                $this->categoryRepository->delete($category);
                return true;
            }
        }

        return false;
    }

    public function getSelectItems(): array
    {
        $arCategorySelect = [];
        $arEntityItems = $this->categoryRepository->getItemsAsArray();

        if (is_array($arEntityItems) && count($arEntityItems) > 0) {
            foreach ($arEntityItems as $item) {
                $arCategorySelect[$item["title"]] = $item["id"];
            }
        }

        return $arCategorySelect;
    }

    public function getTitle(int $id): string
    {
        return ($this->categoryRepository->findById($id))->getTitle();
    }
}