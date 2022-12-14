<?php

namespace App\Entity;

use App\Service\Catalog\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\ManyToMany( targetEntity: 'Product', indexBy: 'cart_id')]
    #[ORM\JoinTable(name: 'cart_products')]
    private Collection $products;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->products = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        $value = 0;
        foreach ($this->products as $product) {
            $value += $product->getPrice();
        }

        return $value;
    }

    #[Pure]
    public function isFull(): bool
    {
        return $this->products->count() >= self::CAPACITY;
    }

    public function getProducts(): array
    {
        $products = [];
        foreach ($this->products as $product) {

            $products[] = $product;
        }

        return $products;
    }

    #[Pure]
    public function hasProduct(\App\Entity\Product $product): bool
    {
        return $this->products->contains($product);
    }

    public function addProduct(\App\Entity\Product $product): void
    {
        $this->products->add($product);
    }

    public function removeProduct(\App\Entity\Product $product): void
    {
        $this->products->removeElement($product);
    }
}
