<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Repositories\Comments\CommentRepository;

use App\Http\Requests\Comments\CommentRequest;

use Illuminate\Http\Response;

use Cookie;
use Validator;
class CommentController extends ClientController
{
    //
    public $module = 'comment';
    public $route = 'admin.comment';
    public $folder = 'comments';
    public function __construct(CommentRepository $CommentRepository)
    {
        parent::__construct();
        $this->repository = $CommentRepository;
    }

    /**
     * tim mot nguoi dung thong qua id
     * @param  integer $id [description]
     * @return model     [description]
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function save(Request $request)
    {
        $cr = new CommentRequest();
        $messages = $cr->messages();
        $rules = $cr->rules();
        // validate turn 1
        $request->validate($rules,$messages);
        // validate turn 2
        $fullRules = $cr->fullrules($request->object);
        $request->validate($fullRules,$messages);
        if($request->email){
            $request->validate(['email'=>'email'],$messages);
        }
        // save data
        $data = [
            'author_name' => $request->name,
            'author_email' => $request->email,
            'author_phone' => $request->phone_number,
            'content' => $request->content,
            'object' => $request->object,
            'object_id' => $request->object_id
        ];
        if($request->user()){
            $data['user_id'] = $request->user()->id;
        }
        $this->repository->save($data);
        return redirect()->back()->with('comment_success','Bạn đã gửi phản hồi thành công!');
    }

    public function ajaxSave(Request $request)
    {
        $cr = new CommentRequest();
        $messages = $cr->messages();
        $status = false;
        $errors = [];
        if(in_array(strtolower($request->object),['post','page','product', 'dynamic'])){
            $rules = $cr->fullrules($request->object);
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()){
                $errors = $validator->errors()->all();
            }
        }else{
            $errors[] = "Lỗi không xác định!";
        }
        
        if(!$errors){
            // save data
            $data = [
                'author_name' => $request->name,
                'author_email' => $request->email,
                'author_phone' => $request->phone_number,
                'content' => $request->content,
                'object' => $request->object,
                'object_id' => $request->object_id
            ];
            if($request->user()){
                $data['user_id'] = $request->user()->id;
            }
            $this->repository->save($data);
            $status = true;
        }
        return response()->json(compact('status','errors'));
    }

    public function makeCookie()
    {
        return (new Response(['status'=>true]))->withCookie(cookie('ttcnc_help', 24,24*60));
    }
    
}
