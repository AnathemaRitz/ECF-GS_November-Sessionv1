<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->setLabel('Id')->onlyOnIndex(),
            TextField::new("lastname")->setLabel('Nom'),
            TextField::new("firstname")->setLabel('Prénom'),
            TextField::new("email")->setLabel('Email')->onlyOnIndex(),
            TextField::new("role")->setLabel('Role')->onlyOnIndex(),
            TextField::new("address")->setLabel('Adresse'),
            NumberField::new("postal")->setLabel('Code Postal'),
            TextField::new("city")->setLabel('Ville'),
            DateTimeField::new("createdAt")->setLabel('Créé le')->onlyOnIndex(),
            DateTimeField::new("updatedAt")->setLabel('Modifié le')->onlyOnIndex(),
        ];
    }
}


