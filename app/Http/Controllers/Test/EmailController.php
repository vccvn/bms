<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Cube\Email;

use Cube\Files;
class EmailController extends Controller
{
    //
    public function index($msg=null)
    {
    	$name = 'Doanln';
    	Email::from('doanln16@gmail.com','Doãn')
    		->to('doanln16@gmail.com', 'Doãn')
    		->subject('xin chao Doan')
    		->body('mail.test')
    		->data(compact('name', 'msg'))
    		->send();
    }
    
}
