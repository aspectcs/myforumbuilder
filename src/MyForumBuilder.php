<?php


namespace Aspectcs\MyForumBuilder;


use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Mockery\Exception;

class MyForumBuilder
{
    private static string $api_url = '//acs.forum-api.com:8888/api/v1/';
    private static string|null $cipher = 'AES-256-CBC';
    private static string|null $app_key;
    private static string|null $app_secret;
    private static string|null $app_token;

    /**
     * @throws \ErrorException
     */
    public static function decryptKeys()
    {
        self::$app_key = env('APP_KEY');
        self::$app_secret = env('APP_SECRET');
        try {
            $encryptor = new Encrypter(base64_decode(Str::after(self::$app_key, 'base64:')), self::$cipher);
            self::$app_token = $encryptor->decryptString(self::$app_secret);
        } catch (\Exception $e) {
            throw new \ErrorException('Error while validating token.');
        }
    }

    /**
     * @throws \ErrorException
     */
    public static function validateKeys($key, $secret)
    {
        $encryptor = new Encrypter(base64_decode($key), self::$cipher);
        $response = Http::acceptJson()->withToken($encryptor->decryptString($secret))->post(self::$api_url . '/');
        $response->onError(function (Response $response) {
            if ($response->unauthorized()) {
                throw new \ErrorException($response->json('message'));
            } else {
                throw new \ErrorException('Something went wrong. please contact to admin.');
            }
        });
        return $response;
    }

    /**
     * @throws \ErrorException
     */
    public static function details()
    {
        self::decryptKeys();
        $response = Http::acceptJson()->withToken(self::$app_token)->post(self::$api_url);
        $response->onError(function (Response $response) {
            if ($response->unauthorized()) {
                throw new \ErrorException($response->json('message'));
            } else {
                throw new \ErrorException('Something went wrong. please contact to admin.');
            }
        });
        return $response;
    }

    /**
     * @throws \ErrorException
     */
    public static function canGenerateQuestion()
    {
        self::decryptKeys();
        $response = Http::acceptJson()->withToken(self::$app_token)->post(self::$api_url.'/');
        $response->onError(function (Response $response) {
            if ($response->unauthorized()) {
                throw new \ErrorException($response->json('message'));
            } else {
                throw new \ErrorException('Something went wrong. please contact to admin.');
            }
        });
        return $response;
    }

}
