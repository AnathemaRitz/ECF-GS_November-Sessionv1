<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
#[ORM\HasLifecycleCallbacks]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $myOrder = null;

    #[ORM\Column(length: 255)]
    private ?string $gameName = null;

    #[ORM\Column(length: 255)]
    private ?string $gameImage = null;

    #[ORM\Column]
    private ?int $gameQuantity = null;

    #[ORM\Column]
    private ?float $gamePrice = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMyOrder(): ?Order
    {
        return $this->myOrder;
    }

    public function setMyOrder(?Order $myOrder): static
    {
        $this->myOrder = $myOrder;

        return $this;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(string $gameName): static
    {
        $this->gameName = $gameName;

        return $this;
    }

    public function getGameImage(): ?string
    {
        return $this->gameImage;
    }

    public function setGameImage(string $gameImage): static
    {
        $this->gameImage = $gameImage;

        return $this;
    }

    public function getGameQuantity(): ?int
    {
        return $this->gameQuantity;
    }

    public function setGameQuantity(int $gameQuantity): static
    {
        $this->gameQuantity = $gameQuantity;

        return $this;
    }

    public function getGamePrice(): ?float
    {
        return $this->gamePrice;
    }

    public function setGamePrice(float $gamePrice): static
    {
        $this->gamePrice = $gamePrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
