<?php
/*
 * Secret key and Site key get on https://dashboard.hcaptcha.com/sites
 * */
return [
    'secret' => env('CAPTCHA_SECRET'),
    'sitekey' => env('CAPTCHA_SITEKEY'),
    // \GuzzleHttp\Client used is the default client
    'http_client' => \Buzz\LaravelHCaptcha\HttpClient::class,
    'options' => [
        'multiple' => false,
        'lang' => app()->getLocale(),
    ],
    'attributes' => [
        'theme' => 'light'
    ],
];
