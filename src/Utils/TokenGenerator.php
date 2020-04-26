<?php


namespace App\Utils;


class TokenGenerator
{
    public static function generate()
    {
        return rtrim(strtr(base64_encode(random_bytes(64)), '+/', '-_'), '=');
    }
}