<?php

namespace Functional\Controller\Catalog\EditController;

use App\Repository\ProductRepository;
use App\Tests\Functional\WebTestCase;


class EditControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_product_update(): void
    {
        $product = (new ProductRepository($this->entityManager))->add('new product', 10);
        $payload = [
            'name' => 'updated product',
            'price' => 15
        ];
        $this->client->request('PUT', 'products/' . $product->getId(), $payload);

        self::assertResponseStatusCodeSame(202);
    }

    public function test_can_validation_works_while_updating():void
    {
        $product = (new ProductRepository($this->entityManager))->add('new product', 10);
        $payload = [
            'name' => 'updated product',
            'price' => 15
        ];
        $this->client->request('PUT', 'products/' . $product->getId(), $payload);
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }
}