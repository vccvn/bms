<?php

namespace App\Apis;

use GuzzleHttp\Client;

class Api {
    protected $http_code = 200;

    // protected $token = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdkYTkzOGUzZTU3YWNlY2UyZDdjM2EwOWRjMGE4NDNhN2YzZTQzYjI4ZjMwZTAzN2M5ZmVhZjk2ZWUxNDA3NThmNjdjOTQ5MjYwN2ViM2Y0In0.eyJhdWQiOiIyIiwianRpIjoiN2RhOTM4ZTNlNTdhY2VjZTJkN2MzYTA5ZGMwYTg0M2E3ZjNlNDNiMjhmMzBlMDM3YzlmZWFmOTZlZTE0MDc1OGY2N2M5NDkyNjA3ZWIzZjQiLCJpYXQiOjE1MzkyNDg2NDMsIm5iZiI6MTUzOTI0ODY0MywiZXhwIjoxNTQwNTQ0NjQzLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.N2Q9WdLmwRqm5UcwwanoX4f74bs0u8ovEqF58eip2OlseZplpSFCsZObZMX6KiK2Zme6HYOycWsr7x6qi4rfTc9rLvfB-UWnwQ-xz2Zi7HhF8C-uZu5cJu6HbjvGfFgVmJJHJuUR50C97ydliLtMEOcVXddr86yB5xaUU5SvPRhKxqiBzG3BfeRoBJWvocUu9bSISo-Dj_2aTesAWeQNoX1QN5NoO2oVnBzzAl9XdL3jgUtzKUC2tuHhSQhBcv3S_EwbgMnhxco86eqlKff6_2K21XOimnMxpC9CIXym7MDdomR5WdTKtwDoJj0fH5FChLjULnOsZBSFai_l75hWLMt3wvTltYKNkpj60YvKyX4YuQIm5-iyjZF4NUA5-fCL6X6tZgGxKaaDPhH8EfzTLRaYZyZxPA-J16G_PS7a9mURBBi-TckI4T_G0WVFdkBYNI1dnbP-pLZsdFmzbn2mpkGJR3H0C0hWJmeYs5thJOsnAZBnGkT9_bQPsXFou4wWuqVL4cL9xYYRSpuqWSiWMVXWpeDGawnHORA2dCCLbSzj8m4W_gLwgjbu7xlrXgznam30r8g6SL8bdXW4QVoXdyzy0nApLm5BoMdXNqUeYBUFKn1i7QEiOTAApL-Pxz1lPy1rn8EKFmGF_2Z3KGTJxXwUKLCUy4JqWKT8XV5-mVo';
    
    function __construct() {
        $this->URL_API = env('API_URL');
    }

    /**
     * gửi request đến API server
     * @param string $method            [= GET / POST / PUT / PATCH / DELETE / OPTION]
     * @param string $url               là sub url nghĩ là không cần địa chỉ server chỉ cần /module/abc...
     * @param array  $data              mãng data get cũng dùng dc luôn
     * @param array  $headers           Mãng header. cái này tùy chọn
     * 
     * @return object Client
     */
    
    public function sendRequest($method, $url, Array $data = [], array $headers = []){
        $client = new Client();
        $headerData = array_merge([
            // 'Authorization' => $this->token,
            // 'content-type'=>'x-www-form-urlencoded',
            // 'content-type' => 'application/json',
            
        ], $headers);
        $api_url = api_url($url);
        $response = $client->request($method, $api_url, [
        'headers' => $headerData,
        //    'form_params' => $data
        'body' => json_encode($data)
        ]);

        return $response;
    }
    
    /**
     * gửi request đến API server lấy kết quả trả về chuyển sang dạng object
     * @param string $method            [= GET / POST / PUT / PATCH / DELETE / OPTION]
     * @param string $url               là sub url nghĩ là không cần địa chỉ server chỉ cần /module/abc...
     * @param array  $data              mãng data get cũng dùng dc luôn
     * @param array  $headers           Mãng header. cái này tùy chọn
     * 
     * @return object std
     * cấu trúc trả về theo tài liệu api
     */
    
    public function json($method, $url, array $data = [], array $headers = []){
        $headerData = array_merge(['content-type' => 'application/json'],$headers);
        $response = $this->sendRequest($method,$url,$data, $headerData);
        return json_decode($response->getBody()->getContents());
    }

    
    public function getHttpCode()
    {
        return $this->http_code;
    }


    public function send($method, $url, $data = [], array $headers = []){
        $client = new Client();
        $response = $client->request($method, $url, [
        'headers' => $headers,
        //    'form_params' => $data
        'body' => json_encode($data)
        ]);
        return $response;
    }
}