<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Repositories\Subcribers\SubcriberRepository;

use App\Http\Requests\Subcribers\SubcriberRequest;

use Illuminate\Http\Response;

use Cookie;
use Validator;
use Cube\Email;


class SubcriberController extends ClientController
{
    public function __construct(SubcriberRepository $SubcriberRepository)
    {
        parent::__construct();
        $this->repository = $SubcriberRepository;
    }

    public function index(Request $request)
    {
        $home_slider = get_slider('home');
        return $this->view($this->module.'.form', compact('home_slider'), 'Subcriber-page');
    }

    

    public function send(Request $request)
    {
        $cr = new SubcriberRequest();
        $messages = $cr->messages();
        $rules = $cr->rules();
        // validate
        $data = $request->validate($rules,$messages);
        // save data
        $this->repository->save($data);
        return redirect()->back()->with('subcribe_success','Bạn đã gửi Liên hệ thành công!');
    }

    public function ajaxSend(Request $request)
    {
        $cr = new SubcriberRequest();
        $messages = $cr->messages();
        $status = false;
        $errors = [];
        $rules = $cr->rules();
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $errors = $validator->errors()->all();
        }
    
        
        if(!$errors){
            // save data
            $data = $request->all();
            $this->repository->save($data);
            $status = true;
            $email = $request->email;
            $siteinfo = $this->siteinfo;
            Email::from($this->siteinfo->email, $this->siteinfo->site_name)
                    ->to($email, 'Quản trị viên') // doviethieulc@gmail.com
                    ->subject('Thông báo: Bạn đã đăng ký thành công')
                    ->body('mail.noitifications.subcriber')
                    ->data(compact('data','siteinfo'))
                    ->send();
                    
        }
        return response()->json(compact('status','errors'));
    }

}
