<?php


namespace App\DataFixtures;


use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Deadlines;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DeadlineFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $datas = $this->getDatas();
        foreach ($datas as $key => $data) {
            $deadline = new Deadlines();
            $deadline->setName($data)->setDescription($faker->text(50));
            $manager->persist($deadline);
        }
        $manager->flush();
    }

    public function getDatas(): array
    {
        return [
            'Pour quel délai ?',
            'Assez urgent',
            'Dans les mois à venir',
            'Plus de 3 mois',
            'Non défini',
        ];
    }
    public function getOrder(): int
    {
        return 3; // the order in which fixtures will be loaded
    }
}
