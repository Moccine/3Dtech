<?php

namespace App\Controller\Admin;

use App\Entity\SlideShow;
use App\Form\SliderType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SlideShowCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SlideShow::class;
    }
    private string $filePath;

    public function __construct()
    {
        $this->filePath =$_ENV['SLIDE_IMAGE_PATH'];
    }

    public function configureFields(string $pageName): iterable
    {
        //$imageFile = ImageField::new('file')->setFormType(VichImageType::class);
       // $image = ImageField::new('image')->setBasePath('/image/slides/');
        $fields = [
            TextField::new('title'),
            TextEditorField::new('description'),
            CollectionField::new('slides')
                ->setEntryType(SliderType::class)->setFormTypeOption('by_reference', false)
                ->onlyOnForms(),
        ];


      if (Crud::PAGE_INDEX == $pageName || Crud::PAGE_DETAIL == $pageName) {
            //$fields[] = $image;
          $fields[] = CollectionField::new('slides')->setTemplatePath('slide/slide.thumbnail.html.twig')->onlyOnDetail();

        }

        return $fields;
    }
}
