<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Machine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MachineFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $machines = $manager->getRepository(Machine::class)->findAll();
        $count = \count($machines) ?? 100;
        for ($i = 0; $i < $count; ++$i) {
            if (0 === \count($machines)) {
                $machine = new Machine();
                $machine->setCategory($this->getReference(CategoryFixtures::CATEGORY_REFERENCE.$i));
            } else {
                $machine = $machines[$i];
            }
            $machine->setAgency($this->getReference(AgencyFixtures::AGENCY_REFERENCE.$i));
            $manager->persist($machine);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgencyFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
