<?php

namespace App\Requests;


use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class AddProductRequest extends BaseRequest
{
    #[NotBlank([])]
    protected string $name;

    #[NotBlank([])]
    #[GreaterThan(1)]
    #[Type('integer')]
    protected int $price;

    /**
     * @return string
     */
    public function getName(): string
    {
        return trim($this->name);
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

}