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
                ->setAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE . $i))
                ->setUser($this->getReference(BuserFixture::USER_REFERENCE . $i));
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
