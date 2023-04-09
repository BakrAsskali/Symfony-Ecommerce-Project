<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $manager->persist($category);

            for ($j = 0; $j < 10; $j++) {
                $product = new Product();
                $product->setName($faker->word);
                $product->setPrice($faker->randomFloat(2, 10, 100));
                $product->setDescription($faker->text());
                $product->setCategory($category);
                $manager->persist($product);
            }
        }
        $manager->flush();
    }
}
