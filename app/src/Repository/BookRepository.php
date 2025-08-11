<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, Book::class);
    }

    public function bookExist(int $categoryId): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('b')
            ->from(Book::class, 'b')
            ->andWhere(
                $queryBuilder->expr()->eq('b.categoryId',':categoryId')
            )
            ->setParameter('categoryId', $categoryId)
            ->setMaxResults(1);

        $book = $queryBuilder->getQuery()->getOneOrNullResult();

        return ($book instanceof Book);
    }
}
