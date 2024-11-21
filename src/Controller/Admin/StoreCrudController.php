<?php

namespace App\Controller\Admin;

use App\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;


class StoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Store::class;
    }

    public function configureCrud(Crud $crud): Crud{
        return $crud
            ->setEntityLabelInSingular('Magasin')
            ->setEntityLabelInPlural('Magasins');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->setLabel('Id')->onlyOnIndex(),
            TextField::new("name")->setLabel('Nom du Magasin'),
            SlugField::new('slug')->setLabel('URL')->setTargetFieldName('name')->setHelp("URL générée automatiquement.")->hideOnIndex(),
            TextField::new("address")->setLabel('Adresse'),
            NumberField::new("postal")->setLabel('Code Postal'),
            TextField::new("city")->setLabel('Ville'),
            TextField::new("email")->setLabel('Mail de contact'),
            DateTimeField::new("createdAt")->setLabel('Créé le')->onlyOnIndex(),
            DateTimeField::new("updatedAt")->setLabel('Modifié le')->onlyOnIndex(),
        ];
    }
}
