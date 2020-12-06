<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the names of the Doctrine entity properties where the search is made on
            // (by default it looks for in all properties)
            ->setSearchFields(['name', 'description'])
            // use dots (e.g. 'seller.email') to search in Doctrine associations
            ->setSearchFields(['name', 'description', 'seller.email', 'seller.phone'])
            // set it to null to disable and hide the search box
            ->setSearchFields(['name', 'code'])

            // defines the initial sorting applied to the list of entities
            // (user can later change this sorting by clicking on the table columns)
            ->setDefaultSort(['id' => 'DESC'])
            ->setDefaultSort(['id' => 'DESC', 'name' => 'ASC'])

            // the max number of entities to display per page
            ->setPaginatorPageSize(50)
            // these are advanced options related to Doctrine Pagination
            // (see https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/tutorials/pagination.html)
            ->setPaginatorUseOutputWalkers(true)
            ->setPaginatorFetchJoinCollection(true)
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
