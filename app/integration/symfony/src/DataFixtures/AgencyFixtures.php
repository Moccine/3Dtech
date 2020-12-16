<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AgencyFixtures extends Fixture
{
    public const AGENCY_REFERENCE = 'agency_ref';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 100; ++$i) {
            $agency = new Agency();
            $agency->setName($faker->company);
            $agency->setAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE.$i));
            $this->addReference(self::AGENCY_REFERENCE.$i, $agency);
            $manager->persist($agency);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AddressFixtures::class,
        ];
    }
}
