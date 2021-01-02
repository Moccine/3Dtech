<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Service\Security\PasswordService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BuserFixture extends Fixture
{
    public const USER_REFERENCE = 'user_ref';
    private PasswordService $passwordService;

    /**
     * UserDataFixture constructor.
     * @param PasswordService $passwordService
     */
    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $user = new User();

            if($i<1){
                $user->addRole(User::ROLE_ADMIN);
                $user->setEmail('so.momo@dbmail.com');
            }
            $password = $this->passwordService->encode($user, 'Connexion2020');
                $user->setEnabled(true)
                ->setPassword($password);
            $this->addReference(self::USER_REFERENCE.$i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
    public function getOrder(): int
    {
        return 4; // the order in which fixtures will be loaded
    }
}
