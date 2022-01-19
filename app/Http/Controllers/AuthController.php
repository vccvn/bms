<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use Redirect;
use App\Repositories\Users\UserRepository;


class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
     
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


    public function checkAuth(Request $request)
    {
        $status = false;
        $user = null;
        if($u = Auth::user()){
            $status = true;
            $user = [
                'name' => $u->name,
                // can gi bo xung
            ];
        }
        return response()->json(compact('status','user'));
    }
    
}
