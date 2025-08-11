<?php

namespace CategoryBundle\Controller\Web\v1\Category\Create\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCategoryDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(
            min: 5,
            max: 255,
            minMessage: "Title must be more than 5 characters",
            maxMessage: "Title must be less than 255 characters"
        )]
        public string $title,

        #[Assert\NotBlank]
        #[Assert\Positive(
            message: "Sort must be positive number"
        )]
        public int $sort,
    ) {
    }
}