<?php

if (!function_exists('get_gravatar')) {
    function get_gravatar($email, $s = 256, $d = 'identicon', $r = 'pg')
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        return $url;
    }
}

if (!function_exists('nl2p')) {
    function nl2p($content)
    {
        return '<p>' . nl2br(e($content)) . '</p>';
    }
}
if (!function_exists('popularTag')) {
    function popularTag($count = 5)
    {
        return \Aspectcs\MyForumBuilder\Models\Tag::popular()->take($count)->get();
    }
}
if (!function_exists('question_slug')) {
    function question_slug($text)
    {
        return \Illuminate\Support\Str::slug($text, '-', 'en', ['&' => 'and', '/' => '-', '%' => '-percent']);
    }
}
if (!function_exists('getSetting')) {
    function getSetting($id)
    {
        return \Aspectcs\MyForumBuilder\Models\Setting::getData($id);
    }
}

if (!function_exists('put_permanent_env')) {
    function put_permanent_env($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('=' . env($key), '/');
        $content = file_get_contents($path);
        $pushContent = null;
        preg_match("/^{$key}{$escaped}/m", $content, $matches);
        if (count($matches) > 0) {
            $pushContent = preg_replace(
                "/^{$key}{$escaped}/m",
                "{$key}={$value}",
                $content
            );
        } else {
            $pushContent = $content . PHP_EOL . "{$key}={$value}";
        }
        return file_put_contents($path, $pushContent);
    }
}
