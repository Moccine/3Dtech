<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $code, ?string $label): Category
    {
        $category = new Category();
        $category->setLabel($label)->setCode($code);
        $this->entityManager->persist($category);

        return $category;
    }
}
