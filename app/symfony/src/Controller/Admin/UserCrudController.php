<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel(false);
            })

            // in PHP 7.4 and newer you can use arrow functions
            // ->update(Crud::PAGE_INDEX, Action::NEW,
            //     fn (Action $action) => $action->setIcon('fa fa-file-alt')->setLabel(false))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('enabled', 'Activer'),
            EmailField::new('email', 'Email'),
            TextField::new('plainPassword', )->hideOnForm()->setValue(function ($dto){
                $dto->getPassword();
                dump($dto);
    })->hideOnForm()->hideOnDetail()->hideOnIndex(),
            ChoiceField::new('roles')->setChoices(array_flip(User::ROLES))->allowMultipleChoices()->onlyOnForms(),
        ];
    }
}
