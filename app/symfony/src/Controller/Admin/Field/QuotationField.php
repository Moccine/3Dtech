<?php
namespace  App\Controller\Admin\Field;

use App\Form\QuotationLineType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class QuotationField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            // this template is used in 'index' and 'detail' pages
            ->setTemplatePath('admin/form.html.twig')
            // this is used in 'edit' and 'new' pages to edit the field contents
            // you can use your own form types too
            ->setFormType(QuotationLineType::class)
            ->addCssClass('field-map')
            // these methods allow to define the web assets loaded when the
            // field is displayed in any CRUD page (index/detail/edit/new)
            //->addJsFiles('build/front.js')
        ;
    }
}