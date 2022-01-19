<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Repositories\Contacts\ContactRepository;

use App\Http\Requests\Contacts\ContactRequest;


use App\Repositories\Contacts\ContactReplyRepository;
use App\Http\Requests\Contacts\ContactReplyRequest;

use Illuminate\Http\Response;

use Cookie;
use Validator;
use Cube\Email;


class ContactController extends ClientController
{
    //
    public $module = 'contact';
    public $route = 'admin.contact';
    public $folder = 'contacts';
    public function __construct(ContactRepository $contactRepository, ContactReplyRepository $contactReplyRepository)
    {
        parent::__construct();
        $this->repository = $contactRepository;
        $this->replyRepository = $contactReplyRepository;
    }

    public function index(Request $request)
    {
        $home_slider = get_slider('home');
        return $this->view($this->module.'.form', compact('home_slider'), 'contact-page');
    }

    

    public function send(Request $request)
    {
        $cr = new ContactRequest();
        $messages = $cr->messages();
        $rules = $cr->rules();
        // validate
        $data = $request->validate($rules,$messages);
        // save data
        $this->repository->save($data);
        return redirect()->back()->with('contact_success','Bạn đã gửi Liên hệ thành công!');
    }

    public function ajaxSend(Request $request)
    {
        $cr = new ContactRequest();
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
            $email = $this->setting->email_get_data?$this->setting->email_get_data:'doanln16@gmail.com';
            $data['admin'] = $email;
            Email::from($this->siteinfo->email, $this->siteinfo->site_name)
                    ->to($email, 'Quản trị viên') // doviethieulc@gmail.com
                    ->subject('Thông báo: Có người liên hệ')
                    ->body('mail.noitifications.contact')
                    ->data(compact('data'))
                    ->send();
                    
        }
        return response()->json(compact('status','errors'));
    }

}
