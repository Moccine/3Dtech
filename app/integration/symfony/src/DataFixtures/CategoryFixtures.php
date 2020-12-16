<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCE = 'category_ref';

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findAll();
        if (0 == \count($categories)) {
            $faker = Factory::create('fr_FR');
            for ($i = 0; $i <= 100; ++$i) {
                $category = new Category();
                $category->setCode($faker->ean13);
                $this->addReference(self::CATEGORY_REFERENCE.$i, $category);
                $manager->persist($category);
            }
            $manager->flush();
        }
    }
}
