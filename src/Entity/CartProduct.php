<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cart_products')]
class CartProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Cart')]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: 'Product')]
    private Product $product;


    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getCart(): Collection
    {
        return $this->cart;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
}