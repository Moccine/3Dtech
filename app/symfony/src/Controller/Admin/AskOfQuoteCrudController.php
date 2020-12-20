<?php

namespace App\Controller\Admin;

use App\Entity\AskOfQuote;
use Doctrine\DBAL\Types\IntegerType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AskOfQuoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AskOfQuote::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextField::new('company', 'Entreprise'),
            IntegerField::new('materialNumber', 'Matriels'),
            IntegerField::new('serverNumber', 'Serveurs'),
            TextEditorField::new('description')->onlyOnDetail(),
            EmailField::new('email', 'email'),
            TextField::new('phone', 'mobile'),
            AssociationField::new('category', 'Projet IT'),
            AssociationField::new('deadline', 'Delai'),
        ];
    }

}
