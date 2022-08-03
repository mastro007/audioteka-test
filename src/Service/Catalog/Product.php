<?php

namespace App\Service\Catalog;

use DateTime;

interface Product
{
    public function getId(): string;
    public function getName(): string;
    public function getPrice(): int;
    public function getCreatedAt(): DateTime;
}
