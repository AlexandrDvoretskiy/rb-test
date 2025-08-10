<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $description = $faker->paragraph;

            // The Description length in the Fixtures was left unchanged
            if (strlen($description) > 80) {
                $description = substr($description, 0, 80) ;
            }

            $book = new Book();
            $book
                ->setTitle($faker->sentence(3))
                ->setAuthor($faker->name)
                ->setPublishedAt($faker->dateTimeBetween('-30 years', 'now'))
                ->setDescription($description)
                ->setIsbn($faker->isbn13)
                ->setCategoryId($faker->numberBetween(1, 3))
            ;
            $manager->persist($book);
        }

        $manager->flush();
    }
}
