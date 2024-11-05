<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/*use Symfony\Component\Security\Core\User\UserInterface;*/


 #[ORM\Entity(repositoryClass: \App\Repository\SellerRepository::class)]
 #[ORM\Table(name: 'seller')]
 class Seller extends User
 {

    #[ORM\ManyToOne(inversedBy: 'sellers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Store $store = null;
     public function __construct()
     {
         $this->setRoles(['ROLE_USER', 'ROLE_SELLER']);
     }
     public function getStore(): ?Store
     {
         return $this->store;
     }

     public function setStore(?Store $store): static
     {
         $this->store = $store;

         return $this;
     }
 }


                            /*public function __construct()
                            {
                                $this->orders = new ArrayCollection();
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


