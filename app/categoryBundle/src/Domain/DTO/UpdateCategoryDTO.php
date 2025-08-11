<?php

namespace CategoryBundle\Domain\DTO;

class UpdateCategoryDTO
{
    public function __construct(
        public string $title,
        public mixed $sort = null,
    ) {
    }
}