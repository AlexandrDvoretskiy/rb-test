<?php

namespace CategoryBundle\DataFixtures;

use CategoryBundle\Domain\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $arCategories = [
            [
                "title" => "Fiction",
                "sort" => 10,
            ],
            [
                "title" => "Science",
                "sort" => 20,
            ],
            [
                "title" => "History",
                "sort" => 30,
            ],
        ];

        foreach ($arCategories as $category) {
            $category = new Category(
                $category['title'],
                $category['sort'],
            );
            $manager->persist($category);
        }

        $manager->flush();
    }
}