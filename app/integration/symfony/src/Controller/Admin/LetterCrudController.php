<?php

namespace App\Controller\Admin;

use App\Entity\Letter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LetterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Letter::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
