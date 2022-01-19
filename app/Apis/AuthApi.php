<?php

namespace App\Api;

use GuzzleHttp\Client;

class AuthApi extends Api {
    /**
     * đăng nhập oauth2
     * @param string $username    Email
     * @param string $password    Mật khẩu
     */
    public function login($username, $password)
    {
        $data = [
            'client_id'      => env('CLIENT_ID'),
            'client_secret'  => env('CLIENT_SECRET'),
            'grant_type'     => 'password',
            'scope'          => '*',
            'username'       => $username,
            'password'       => $password,
        ];

    }
}