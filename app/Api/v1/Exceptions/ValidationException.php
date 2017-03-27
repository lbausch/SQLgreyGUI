<?php

namespace SQLgreyGUI\Api\v1\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

class ValidationException extends Exception
{
    /**
     * Errors.
     *
     * @var MessageBag
     */
    protected $errors;

    /**
     * ValidationException constructor.
     *
     * @param array|string $errors
     */
    public function __construct($errors)
    {
        if (!is_array($errors)) {
            $errors = ['*' => $errors];
        }

        $this->errors = new MessageBag();

        foreach ($errors as $field => $message) {
            $this->errors->add($field, $message);
        }
    }

    /**
     * Get response.
     *
     * @return JsonResponse
     */
    public function getResponse()
    {
        return new JsonResponse($this->errors->toArray(), 422);
    }
}
