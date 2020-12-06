<?php

namespace App\Controller\Admin;

use App\Entity\Quotation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class QuotationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quotation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextField::new('reference', 'Reference'),
            TextField::new('payment', 'Mode de payement'),
            //TextField::new('designation'),
            TextField::new('address', 'Adresse'),
            NumberField::new('quantity', 'Quantité'),
            AssociationField::new('deadline', 'Délai'),
            AssociationField::new('client', 'Client'),
            AssociationField::new('products', 'Produits'),
            MoneyField::new('totalHT', 'HT')->hideOnForm()->setCurrency('EUR'),
            MoneyField::new('Amount', 'TTC')->hideOnForm()->setCurrency('EUR'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        return parent::createEntity($entityFqcn); // TODO: Change the autogenerated stub
    }

}
