<?php

namespace App\Http\Resources;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class FormatResource
{
    public static function error(int $code, $errors): HttpResponseException
    {
        throw new HttpResponseException(response([
            "code" => $code,
            "status" => self::getStatus($code),
            "errors" => $errors
        ], $code));
    }

    public static function success(int $code, $data): Response
    {
        return response([
            "code" => $code,
            "status" => self::getStatus($code),
            "data" => $data
        ], $code);
    }

    public static function getStatus(int $code)
    {
        switch ($code) {
            case 200:
                return 'OK';
            case 201:
                return 'Created';
            case 400:
                return 'Bad Request';
            case 401:
                return 'Unauthorize';
            default:
                return null;
        }
    }
}
