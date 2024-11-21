<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Client')
            ->setEntityLabelInPlural('Clients');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
//            TODO : la fonction remove ne protège pas d'un forcing via l'url, vérifier cela
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->setLabel('Id')->onlyOnIndex(),
            TextField::new("lastname")->setLabel('Nom')->setDisabled(true),
            TextField::new("firstname")->setLabel('Prénom')->setDisabled(true),
            TextField::new("email")->setLabel('Email')->setDisabled(true),
            TextField::new("address")->setLabel('Adresse')->setDisabled(true),
            NumberField::new("postal")->setLabel('Code Postal')->setDisabled(true),
            TextField::new("city")->setLabel('Ville')->setDisabled(true),
            DateTimeField::new("createdAt")->setLabel('Créé le')->onlyOnIndex(),
            DateTimeField::new("updatedAt")->setLabel('Modifié le')->onlyOnIndex(),

        ];
    }
//    TODO : créer une vue de récap des commandes clients et un field de count sur l'index '

}


