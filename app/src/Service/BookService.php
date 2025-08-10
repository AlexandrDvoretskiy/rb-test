<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;

class BookService
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    ) {
    }

    public function hasBooks(int $categoryId): bool
    {
        return $this->bookRepository->bookExist($categoryId);
    }
}