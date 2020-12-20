<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use App\Form\SliderType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SliderCrudController extends AbstractCrudController
{
    private string $filePath;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->filePath = $parameterBag->get('app.path.slide_images');
    }
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }


    public function configureFields(string $pageName): iterable
    {


        $image =ImageField::new('image', 'Image')->onlyOnIndex()->setBasePath('/images/slides')->setUploadDir('public/slides')
;
       // $file = ImageField::new('file', 'Image')->onlyOnForms()->setFormType(VichImageType::class)
        ;



        $fields = [
            TextField::new('title'),
        ];

        if (Crud::PAGE_INDEX == $pageName || Crud::PAGE_DETAIL == $pageName) {
            $fields[] = $image;
        } else {
            $fields[] = $file
                //->setFormType(VichImageType::class)
            ;
        }

        return $fields;
    }

}
