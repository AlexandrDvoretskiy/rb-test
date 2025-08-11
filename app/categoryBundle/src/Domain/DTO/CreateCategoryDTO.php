<?php

namespace CategoryBundle\Domain\DTO;

class CreateCategoryDTO
{
    public function __construct(
        public string $title,
        public int $sort,
    ) {
    }
}