<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class GenreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Genre::class;
    }

    public function configureCrud(Crud $crud): Crud{
        return $crud
            ->setEntityLabelInSingular('Genre')
            ->setEntityLabelInPlural('Genres');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->setLabel('Id')->onlyOnIndex(),
            TextField::new("name")->setLabel('Nom')->setHelp("Genre du jeu "),
            SlugField::new("slug")->setLabel('Slug')->setTargetFieldName('name')->setHelp("URL autogénérée du genre."),
            DateTimeField::new("createdAt")->setLabel('Date de création')->onlyOnIndex(),
            DateTimeField::new("updatedAt")->setLabel('Date de modification')->onlyOnIndex(),
        ];
    }
}
