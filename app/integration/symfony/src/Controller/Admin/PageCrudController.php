<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class PageCrudController extends AbstractCrudController
{
    private string $filePath;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->filePath = $parameterBag->get('app.path.page_images');

    }

    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('title'),
            TextField::new('slug'),
            TextEditorField::new('content')
        ];

        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields [] = ImageField::new('image')->setBasePath($this->filePath);
        } else {
            $fields [] = ImageField::new('file')->setFormType(VichImageType::class);;
        }

        return $fields;
    }
}
