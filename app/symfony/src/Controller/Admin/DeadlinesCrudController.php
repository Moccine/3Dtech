<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Deadlines;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DeadlinesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Deadlines::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Delai')
            ->setEntityLabelInPlural('Delais')
            ->setPageTitle('edit', 'Modifier');

            // ...
            ;
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
