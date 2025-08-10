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

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
