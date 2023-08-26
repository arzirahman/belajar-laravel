<?php

namespace App\Http\Resources;

use Illuminate\Http\Exceptions\HttpResponseException;

class FormatResource
{
    public static function error(int $code, $errors): array
    {
        throw new HttpResponseException(response([
            "code" => $code,
            "status" => self::getStatus($code),
            "errors" => $errors
        ], $code));
    }

    public static function success(int $code, $data): array
    {
        throw new HttpResponseException(response([
            "code" => $code,
            "status" => self::getStatus($code),
            "data" => $data
        ], $code));
    }

    public static function getStatus(int $code)
    {
        switch ($code) {
            case 200:
                return 'OK';
            case 400:
                return 'Bad Request';
            default:
                return null;
        }
    }
}
