<?php

namespace App\Service\Catalog;

interface ProductService
{
    public function add(string $name, int $price): Product;
    public function edit(string $id, string $name): void;
    public function remove(string $id): void;
}