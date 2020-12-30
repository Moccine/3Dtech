<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Quotation;
use App\Form\ProductType;
use App\Form\QuotationLineType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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
use App\Controller\Admin\Field\QuotationField;

class QuotationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quotation::class;
    }
   /*   public function configureCrud(Crud $crud): Crud
    {
        return  $crud->overrideTemplates([
        'crud/new' => 'admin/pages/new.html.twig',
    ]);
    }*/

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            // the argument of these methods is passed to the asset() Twig function
            // CSS assets are added just before the closing </head> element
            // and JS assets are added just before the closing </body> element
            ->addJsFile('/build/front.js');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextField::new('reference', 'Reference'),
            TextField::new('payment', 'payement'),
            TextField::new('designation'),
            AssociationField::new('deadline', 'Délai'),
            AssociationField::new('client', 'Client'),
          //  CollectionField::new('quotationLine', 'quotationLine'),
            CollectionField::new('quotationLine', 'Offres')
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(true)
                ->setEntryType(QuotationLineType::class)
                ->setFormTypeOptions([
                    'by_reference' => 'false'
                ]),


            MoneyField::new('totalHT', 'HT')->hideOnForm()->setCurrency('EUR'),
            MoneyField::new('Amount', 'TTC')->hideOnForm()->setCurrency('EUR'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {

        $viewInvoice = Action::new('View Invoice', 'Facturer')->linkToCrudAction(Crud::PAGE_INDEX);

        return $actions->add(Crud::PAGE_INDEX, $viewInvoice);

    }

    public function createEntity(string $entityFqcn)
    {
        return parent::createEntity($entityFqcn); // TODO: Change the autogenerated stub
    }

}
