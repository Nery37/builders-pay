<?php

namespace App\Exceptions;

use App\Enums\BilletMessageEnum;
use App\Enums\HttpStatusCodeEnum;
use Exception;
use Illuminate\Http\Response;

class BilletExceptions extends Exception
{
    public function render(): Response
    {
        return response([
            'error' => $this->getMessage(),
        ], $this->getCode());
    }

    public static function failedToConsultAPIException(): self
    {
        $message = BilletMessageEnum::FAILED_TO_CONSULT_API->value;
        $code = HttpStatusCodeEnum::HTTP_BAD_REQUEST->value;

        return new static($message, $code);
    }

    public static function invalidBilletTypeException(): self
    {
        $message = BilletMessageEnum::INVALID_BILLET_TYPE->value;
        $code = HttpStatusCodeEnum::HTTP_UNPROCESSABLE_ENTITY->value;

        return new static($message, $code);
    }

    public static function billetExpired(): self
    {
        $message = BilletMessageEnum::BILLET_EXPIRED->value;
        $code = HttpStatusCodeEnum::HTTP_NOT_ACCEPTABLE->value;

        return new static($message, $code);
    }

    public static function authAccessTokenFailedException(): self
    {
        $message = BilletMessageEnum::AUTH_ACCESS_TOKEN_FAILED->value;
        $code = HttpStatusCodeEnum::HTTP_BAD_REQUEST->value;

        return new static($message, $code);
    }
}
