<?php


namespace App\DataFixtures;


use App\Entity\Address;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{

    const CATEGORY_REFERENCE = 'category_ref';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $datas = $this->getDatas();
        foreach ($datas as $key => $data) {
            $category = new Category();
            $category->setName($data)
                ->setDescription($faker->text(50))
            ->setCode($faker->vat)
            ;
            $manager->persist($category);
        }
        $manager->flush();
    }

    public function getDatas(): array
    {
        return [
            'Maintenance / Infogérance',
            'Sécurité IT',
            'Solution Cloud',
            'Sauvegarde externalisée',
            'Accès internet',
            'Réseau wifi',
            'Équipements',
            'Autre',
        ];
    }
    public function getOrder(): int
    {
        return 2; // the order in which fixtures will be loaded
    }
}
