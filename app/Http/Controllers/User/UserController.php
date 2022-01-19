<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    /**
     * view blade file
     * @param string $filename  tên file
     * @param array $data       Dữ liệu truyền tới view
     * @return view
     */
    public function view($filename,$data=null)
    {
        if(!is_array($data)) $data = [];
        return view('user.'.$filename,$data);
    }
}
