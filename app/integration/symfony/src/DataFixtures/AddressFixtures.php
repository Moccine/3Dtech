<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixtures extends Fixture
{
    public const ADDRESS_REFERENCE = 'address_ref';
    public const DEFAULT_COUNTRY = 'France';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 100; ++$i) {
            $address = new Address();
            $address->setAddress($faker->buildingNumber.', '.$faker->streetName)
                ->setPostalCode($faker->postcode)
                ->setCity($faker->city)->setCountry(self::DEFAULT_COUNTRY)
                ->setLatitude($faker->latitude(43, 49))->setLongitude($faker->longitude(1.1, 1.5));
            $this->addReference(self::ADDRESS_REFERENCE.$i, $address);
            $manager->persist($address);
        }

        $manager->flush();
    }
}
