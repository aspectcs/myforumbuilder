<?php


namespace Aspectcs\MyForumBuilder;


use Aspectcs\MyForumBuilder\Models\Question;
use Carbon\Carbon;
use Composer\InstalledVersions;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MyForumBuilder
{
//    private static string $api_url = '//api.myforumbuilder.com/api/v1/';
    private static string $api_url = '//acs.forum-api.com:8888/api/v1/';
    private static string|null $cipher = 'AES-256-CBC';
    private static string|null $app_key;
    private static string|null $app_secret;
    private static string|null $app_token;

    private static string $package = 'aspectcs/myforumbuilder';


    /**
     * @throws \ErrorException
     */
    private static function decryptKeys()
    {
        self::$app_secret = env('APP_SECRET');
        try {
            self::$app_token = self::decrypt(self::$app_secret);
        } catch (\Exception $e) {
            throw new \ErrorException('Error while validating token.');
        }
    }

    /**
     * @throws \ErrorException
     */
    private static function encrypt(string $plainText): string
    {
        self::$app_key = env('APP_KEY');
        try {
            $encryptor = new Encrypter(base64_decode(Str::after(self::$app_key, 'base64:')), self::$cipher);
            return $encryptor->encryptString($plainText);
        } catch (\Exception $e) {
            throw new \ErrorException('Error while encrypting token.');
        }
    }

    /**
     * @throws \ErrorException
     */
    private static function decrypt($cipherText): string
    {
        self::$app_key = env('APP_KEY');
        try {
            $encryptor = new Encrypter(base64_decode(Str::after(self::$app_key, 'base64:')), self::$cipher);
            return $encryptor->decryptString($cipherText);
        } catch (\Exception $e) {
            throw new \ErrorException('Error while decrypting data.');
        }
    }

    /**
     * @throws \ErrorException
     */
    public static function validateKeys($key, $secret)
    {
        $encryptor = new Encrypter(base64_decode(Str::after($key, 'base64:')), self::$cipher);
        $response = Http::acceptJson()->withToken($encryptor->decryptString($secret))->post(self::$api_url . 'details');
        $response->onError(function (Response $response) {
            if ($response->unauthorized()) {
                throw new \ErrorException($response->json('message'));
            } else {
                throw new \ErrorException($response);
            }
        });
    }

    /**
     * @throws \ErrorException
     */
    public static function details()
    {
        self::decryptKeys();
        $response = Http::acceptJson()->withToken(self::$app_token)->post(self::$api_url . 'details');
        $response->onError(function (Response $response) {
            if ($response->unauthorized()) {
                throw new \ErrorException($response->json('message'));
            } else {
                throw new \ErrorException($response->json('message'));
            }
        });
        return $response;
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    public static function question(Question $question)
    {
        self::decryptKeys();
        $response = Http::acceptJson()->withToken(self::$app_token)->post(self::$api_url . 'question', [
            'question' => $question,
            'timestamp' => Carbon::now()
        ]);
        $response->onError(function (Response $response) {
            if ($response->unauthorized()) {
                throw new \ErrorException($response->json('message'));
            } else {
                throw new \ErrorException($response->json('message'));
            }
        });
        if ($response->ok()) {
            Config::set(self::decrypt($response->json('chunk.key')), self::decrypt($response->json('chunk.value')));
        }
        return $response;
    }

    /**
     * @throws \ErrorException
     */
    public static function error(Question $question, string $exception)
    {
        self::decryptKeys();
        return Http::acceptJson()->withToken(self::$app_token)->post(self::$api_url . 'exception', [
            'question' => $question,
            'exception' => $exception,
            'timestamp' => Carbon::now()
        ]);
    }

    /**
     * @throws \Exception
     */
    public static function checkUpdate()
    {
        self::decryptKeys();
        if (InstalledVersions::isInstalled(self::$package)) {
            $version = InstalledVersions::getPrettyVersion(self::$package);
        } else {
            throw new \ErrorException('Package not installed');
        }
        $response = Http::acceptJson()->withToken(self::$app_token)->post(self::$api_url . 'check-update', [
            'version' => $version,
            'timestamp' => Carbon::now()
        ]);
        $response->onError(function (Response $response) {
            if ($response->unauthorized()) {
                throw new \ErrorException($response->json('message'));
            } else {
                throw new \ErrorException($response->json('message'));
            }
        });
        return $response;
    }

    public static function update()
    {
        return shell_exec('composer update ' . self::$package);
    }
}
