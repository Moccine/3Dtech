<?php


namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $categories = $manager->getRepository(Category::class)->findAll();
        for ($i = 0; $i <= count($categories); $i++) {
            $key = rand(0, count($categories));
            $category = $categories[$key] ?? null;
            if ($category instanceof Category) {
                $product = new Product();
                $product->setCode(rand(2000, 100000) . $faker->randomLetter)
                        ->setCategory($category)->setName('Produit'.$faker->randomLetter)
                ->setPrice(rand(10, 200));
                $manager->persist($product);
            }
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1; // the order in which fixtures will be loaded
    }
}
