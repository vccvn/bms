<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

class TestController extends ClientController
{
    public function index()
    {
        $header = apache_request_headers(); 
        if(isset($header['x-up-calling-line-id']) && !empty($header['x-up-calling-line-id'])){
            $phone_number = $header['x-up-calling-line-id'];
        }else{
            $phone_number = "Phone number missing...!";
        }
        echo $phone_number;
        dump($header);
    }

    public function alert()
    {
        return $this->view('error.alert');
    }

}
