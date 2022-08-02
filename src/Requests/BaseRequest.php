<?php

namespace App\Requests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class BaseRequest
 * @package
 */
abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
        $this->validate();
    }

    public function validate()
    {
        $errors = $this->validator->validate($this);
        $messages = ['message' => 'validation_failed', 'errors' => []];

        /** @var \Symfony\Component\Validator\ConstraintViolation $msg */
        foreach ($errors as $msg) {
            $messages['errors'][] = [
                'property' => $msg->getPropertyPath(),
                'message' => $msg->getMessage()
            ];
        }
        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages, Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->send();

            exit;
        }
    }

    public function getRequest(): array
    {
        return Request::createFromGlobals()->request->all();
    }

    public function populate(): void
    {
        foreach ($this->getRequest() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}