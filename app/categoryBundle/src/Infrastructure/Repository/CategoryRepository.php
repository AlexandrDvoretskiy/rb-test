<?php

namespace CategoryBundle\Infrastructure\Repository;

use CategoryBundle\Domain\DTO\UpdateCategoryDTO;
use CategoryBundle\Domain\Entity\Category;

class CategoryRepository extends AbstractRepository
{
    public function create(Category $category): int
    {
        return $this->store($category);
    }

    public function findById(int $id): ?Category
    {
        return $this->entityManager->getRepository(Category::class)->find($id);
    }

    public function update(int $id, UpdateCategoryDTO $updateCategoryDTO): mixed
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Category::class, 'c')
            ->set('c.title', ':title')
            ->andWhere(
                $queryBuilder->expr()->eq('c.id',':id')
            )
            ->setParameter('id', $id)
            ->setParameter('title', $updateCategoryDTO->title);

        if ($updateCategoryDTO->sort) {
            $queryBuilder
                ->set('c.sort', ':sort')
                ->setParameter('sort', $updateCategoryDTO->sort);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function delete(Category $category): void
    {
        $this->remove($category);
        $this->flush();
    }

    public function getItemsAsArray(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('c.id', 'c.title')
            ->from(Category::class, 'c')
            ->orderBy('c.sort', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
}