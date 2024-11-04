<?php

namespace App\Controller\Admin;

use App\Entity\Seller;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class SellerCrudController extends AbstractCrudController

{

    public static function getEntityFqcn(): string
    {
        return Seller::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Vendeur')
            ->setEntityLabelInPlural('Vendeurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id")->setLabel('Id')->onlyOnIndex(),
            TextField::new("lastname")->setLabel('Nom'),
            TextField::new("firstname")->setLabel('Prénom'),
            TextField::new("email")->setLabel('Email'),
            TextField::new("role")->setLabel('Role')->onlyOnIndex(),
            TextField::new ('password')->setLabel('Mot de passe')->onlyWhenCreating(),
            /*TODO : Actuellement le mot de passe est stocké en clair, créer un custom field easy admin pour le hasher. Repartir du register form ?
               ->add('plainPassword', RepeatedType::class, [
        'type' => PasswordType::class,
        'constraints' => [
            new Length([
                'min'=> 8,
                'max'=>30
            ])
        ],
        'first_options'  => ['label' => 'Votre mot de passe',
            'attr' =>[
                'placeholder'=>"Choisissez un mot de passe avec au minimum 8 caractères, dont une majuscule et un symbole"
            ],
            'hash_property_path' => 'password'],
        'second_options' => ['label' => 'Confirmation mot de passe',
            'attr' =>[
                'placeholder'=>"Confirmez votre mot de passe"
            ]],
        'mapped' => false,
    ]);*/
            AssociationField::new('store')->setLabel('Magasin'),
        ];
    }
}
