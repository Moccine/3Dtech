<?php


namespace App\DataFixtures;


use App\Entity\Client;
use App\Entity\User;
use App\Service\Security\PasswordService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ClientFixture extends Fixture
{
    const DEFAULT_COUNTRY = 'France';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $client = new Client();
            $client->setCompany($faker->company)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setHomePhone($faker->phoneNumber)
                ->setMobilePhone($faker->phoneNumber)
                ->setSiret($faker->siret)
                ->setStreet($faker->buildingNumber . ', ' . $faker->streetName)
                ->setPostalCode($faker->postcode)
                ->setCity($faker->city)->setCountry(self::DEFAULT_COUNTRY)
                ->setLatitude($faker->latitude(43, 49))->setLongitude($faker->longitude(1.1, 1.5));
            $client->setUser($this->getReference(BuserFixture::USER_REFERENCE . $i));
            $manager->persist($client);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AddressFixtures::class,
            BuserFixture::class,
        ];
    }

    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}
