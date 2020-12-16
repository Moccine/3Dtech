<?php

namespace App\Service\Comparator;

use App\Constant\Product;
use App\Entity\Attribute;
use App\Entity\Machine;
use App\Entity\MachineAttribute;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ComparatorService implements ComparatorInterface
{
    private SessionInterface $session;
    private EntityManagerInterface $em;

    public function __construct(SessionInterface $session, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function getAttributes(): array
    {
        $machines = $this->getMachines();
        $attributes = [];
        if ($machines) {
            /** @var Machine $machine */
            foreach ($machines as $machine) {
                $machineAttributes = $machine->getMachineAttributes()->toArray();
                /** @var MachineAttribute $machineAttribute */
                foreach ($machineAttributes as $machineAttribute) {
                    $attributeId = $machineAttribute->getAttribute()->getId();
                    $attribute = $this->em->getRepository(Attribute::class)->find($attributeId);
                    $values = $machineAttribute->getValue();
                    $value = isset($values[Product::DEFAULT_LABEL]) ? $values[Product::DEFAULT_LABEL] : $values['data'];
                    $attributes[$machine->getCode()][] = [
                        'label' => $attribute->getLabel()[Product::DEFAULT_LABEL],
                        'value' => $value,
                    ];
                }
            }
        }

        return $attributes;
    }

    public function getMachines(): array
    {
        return $this->session->get(Product::MACHINE) ?? [];
    }

    /**
     * @return mixed
     */
    public function addComparator(Machine $machine): void
    {
        $machines = $this->session->get(Product::MACHINE) ?? [];
        if (!\array_key_exists($machine->getCode(), $machines)) {
            $machines[$machine->getCode()] = $machine;
        }
        $this->session->set(Product::MACHINE, $machines);
    }
}
