<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class AlertController extends ClientController
{

    public function index()
    {
        return $this->view('alert.message');
    }

    public function message(Request $request)
    {
        return $this->view('alert.message', $request->all());
    }

    public function error(Request $request)
    {
        return $this->view('alert.message', ['type'=>'danger','message'=>$request->message]);
    }

}
