<?php

namespace CategoryBundle\Controller\Web\v1\Category\Update\Input;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateCategoryDTO
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

        #[Assert\Type(
            "integer",
            message: "Sort must be an integer",
        )]
        #[Assert\Positive(
            message: "Sort must be positive number"
        )]
        public mixed $sort = null,
    ) {
    }
}