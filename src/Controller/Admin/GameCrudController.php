<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;


class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Jeu')
            ->setEntityLabelInPlural('Jeux');
    }

    public function configureFields(string $pageName): iterable
    {
        $required = true;

        if ($pageName=='edit') {
            $required= false;

        }

        $currentYear = date("Y");
        $releaseYearRange = range(1972, $currentYear);
        $releaseYearRange = array_reverse($releaseYearRange);

        return [

            IdField::new('ID')->setLabel("Id ")->onlyOnIndex(),
            AssociationField::new('genre', 'Genre'),
            TextField::new('name')->setLabel('Titre')->setHelp("Titre du jeu"),
            SlugField::new('slug')->setLabel('URL')->setTargetFieldName('name')->setHelp("URL générée automatiquement.")->hideOnIndex(),
            TextEditorField::new('description')->setLabel('Description')->setHelp("Description du jeu"),
            ChoiceField::new('pegi')->setLabel('PEGI')->setChoices([
               '3'=> '3',
                '7'=> '7',
                '12'=> '12',
                '16'=> '16',
                '18'=> '18',
            ]),

            ChoiceField::new('releaseYear')
                ->setLabel('Année de sortie')
                ->setHelp('Année de sortie du jeu (Facultatif) ')
                ->setChoices(array_combine($releaseYearRange, $releaseYearRange)),

            TextField::new('publisher')->setLabel('Éditeur')->setHelp("Nom de l'éditeur du jeu (Facultatif)"),

            ImageField::new('image')
                ->setLabel('Image')
                ->setHelp('Image du jeu')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setBasePath("/uploads")
                ->setUploadDir('/public/uploads')
                ->setRequired($required),

            MoneyField::new('price')->setLabel('Prix TTC')->setCurrency('EUR')->setHelp('Prix unitaire TTC du jeu.')->setStoredAsCents(false),
            IntegerField::new('stock')->setLabel('Stock')->setHelp('Quantité en stock'),

            /*DateTimeField::new("createdAt")->setLabel('Date de création')->onlyOnIndex(),
            DateTimeField::new("updatedAt")->setLabel('Date de modification')->onlyOnIndex(),*/

        ];
    }
}



