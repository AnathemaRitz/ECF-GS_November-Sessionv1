<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;

class OrderCrudController extends AbstractCrudController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
       $this->em= $entityManagerInterface;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes');
    }

    public function configureActions(Actions $actions): Actions
    {

        $show = Action::new("Afficher")->linkToCrudAction('show');

        return $actions
            ->add(Crud::PAGE_INDEX, $show)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_INDEX, Action::EDIT);
    }

    public function changeState($order, $state){
        $order->setState($state);
        $this->em->flush();

        $this->addFlash('success', "Statut correctement modifié.");

}

    public function show(AdminContext $context, AdminUrlGenerator $adminUrlGenerator, Request $request)
    {
        $order = $context->getEntity()->getInstance();

        $url=$adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction("show")
                ->setEntityId($order->getId())
            ->generateUrl();

        if($request->get('state')){
            $this->changeState($order,$request->get('state'));
        }
        return $this->render('admin/order.html.twig',[
                'order'=>$order,
                'current_url'=>$url,
            ]
        );
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('createdAt'),
            NumberField::new('state')->setLabel("Statut de la commande")->setTemplatePath('admin/state.html.twig'),
            AssociationField::new('user')->setLabel('Client'),
            TextField::new('storeName')->setLabel('Magasin de retrait'),
            DateField::new('pickupDate')->setLabel('Date de retrait'), /*Doit être non modifiable*/
            /*
            DateField::new('updatedAt'),*/
            NumberField::new('total')->setLabel("Total")

        ];
    }

}
