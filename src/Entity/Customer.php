<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/*use Symfony\Component\Security\Core\User\UserInterface;*/


 #[ORM\Entity(repositoryClass: \App\Repository\CustomerRepository::class)]
                #[ORM\Table(name: 'customer')]
               
               class Customer extends User
               {
                  /* #[ORM\Column]
                   private array $roles = [];*/
               
                   #[ORM\Column(length: 255)]
                   private ?string $address = null;

                    #[ORM\Column(type: Types::INTEGER, length: 6, options: ['unsigned' => true])]
                    private ?int $postal = null;
               
                   #[ORM\Column(length: 255)]
                   private ?string $city = null;
               
                   /**
                    * @var Collection<int, Order>
                    */
                   #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'customer')]
                   private Collection $orders;

               
                   public function __construct()
                   {
                       $this->orders = new ArrayCollection();
                       $this->setRoles(['ROLE_USER', 'ROLE_CUSTOMER']);
                   }
               
               /*    /**
                    * @see UserInterface
                    *
                    * @return list<string>
                    */
                   /*public function getRoles(): array
                   {
                       $roles = $this->roles;
                       // guarantee every user at least has ROLE_USER
                       $roles[] = 'ROLE_USER';
               
                       return array_unique($roles);
                   }*/
               
                /*   /**
                    * @param list<string> $roles
                    */
                  /* public function setRoles(array $roles): static
                   {
                       $this->roles = $roles;
               
                       return $this;
                   }*/
               
                   public function getAddress(): ?string
                   {
                       return $this->address;
                   }
               
                   public function setAddress(string $address): static
                   {
                       $this->address = $address;
               
                       return $this;
                   }
               
                   public function getPostal(): ?int
                   {
                       return $this->postal;
                   }
               
                   public function setPostal(int $postal): static
                   {
                       $this->postal = $postal;
               
                       return $this;
                   }
               
                   public function getCity(): ?string
                   {
                       return $this->city;
                   }
               
                   public function setCity(string $city): static
                   {
                       $this->city = $city;
               
                       return $this;
                   }

     /**
      * @return Collection<int, Order>
      */
     public function getOrders(): Collection
     {
         return $this->orders;
     }

     public function addOrder(Order $order): static
     {
         if (!$this->orders->contains($order)) {
             $this->orders->add($order);
             $order->setCustomer($this);
         }

         return $this;
     }

     public function removeOrder(Order $order): static
     {
         if ($this->orders->removeElement($order)) {
             // set the owning side to null (unless already changed)
             if ($order->getCustomer() === $this) {
                 $order->setCustomer(null);
             }
         }

         return $this;
     }
 }


