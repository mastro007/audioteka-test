<?php

namespace App\Controller\Catalog;

use App\Messenger\EditProduct;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/{product}", methods={"PUT"}, name="product-edit")
 */
class EditController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;


    public function __construct(private ErrorBuilder $errorBuilder)
    {
    }

    public function __invoke(Request $request): Response
    {
        $this->dispatch(new EditProduct($request->get('product'), $request->get('name')));
        return new Response('', Response::HTTP_ACCEPTED);

    }
}