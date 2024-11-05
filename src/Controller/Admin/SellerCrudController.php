<?php

namespace App\Controller\Admin;

use App\Entity\Seller;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Length;


class SellerCrudController extends AbstractCrudController

{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

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
            TextField::new('plainPassword')->setLabel('Mot de passe')->onlyWhenCreating()->setFormType(RepeatedType::class)->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Votre mot de passe',
                    'attr' => [
                        'placeholder' => "Choisissez un mot de passe avec au minimum 8 caractères, dont une majuscule et un symbole"
                    ],
                ],
                'second_options' => ['label' => 'Confirmation mot de passe',
                    'attr' => [
                        'placeholder' => "Confirmez votre mot de passe"
                    ],
                ],
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 30
                    ])
                ],
            ])->setRequired(true),
            AssociationField::new('store')->setLabel('Magasin'),
        ];
    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Seller) {
            return;
        }

        $request = $this->getContext()->getRequest();
        $plainPassword=$request->request->all()['Seller']['plainPassword']['first'];

        if ($plainPassword) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $plainPassword);
            $entityInstance->setPassword($hashedPassword);
        }

        parent::persistEntity($entityManager, $entityInstance);
        }
    }




