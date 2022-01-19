<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Tags\TagRequest;
use App\Repositories\Tags\TagRepository;

use Validator;
use Cube\Html\Menu as HtmlMenu;


class TagController extends AdminController
{
	public $module = 'tag';
	public $route = 'admin.content.tag';
	public $folder = 'tag';

    public function __construct(TagRepository $tagRepository)
    {
        $this->repository = $tagRepository;
        HtmlMenu::addActiveKey('admin_menu','tag');
    }


    /**
     * hien thi danh sach ban ghi
     * @param  Request $request [description]
     * @return view             [description]
     */
    public function list(Request $request)
    {
        $list = $this->repository->filter($request,['@order_by' => ['id'=>'DESC']]);
        return $this->view($this->module.'.list',compact('list'));
    }

    public function getTag(Request $request)
    {
        $status = false;
        $tag = null;
        if($request->id && $t = $this->find($request->id)){
            $status = true;
            $tag = $t;
        }
        return response()->json(compact('status','tag'));
    }

    public function getData(Request $request)
    {
        $args = [
            '@limit' => 15,
            '@find' => $request->keywords
        ];
        $status = true;
        $data = [];
        try{
            if($d = $this->repository->getData($args)){
                $data = $d;
            }    
        }catch(exception $e){
            $status = false;
        }
        return response()->json(compact('status','data'));
    }

    public function add(Request $request)
    {
        $status = false;
        $data = [];
        if(strlen($request->tags)){
            if($list = $this->repository->addTags($request->tags)){
                $status = true;
                $data = $list;
            }
        }
        return response()->json(compact('status','data'));
    }


    
    /**
     * cap nhat thong tin ban ghi
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(Request $req)
    {
        $tr = new TagRequest;
        $req->validate($tr->rules($req), $tr->messages());
        if($a = $this->repository->addIfNotExists($req->tag)){
            $t = count($a);
            $message = "Bạn đã thêm ".($t==1?"thẻ $req->tag":"$t thẻ")." thành công!";
        }else{
            $message = "Thẻ bạn muốn thêm có thể đã được thêm trước đó";
        }
        return redirect()->route($this->route)->with('message',$message);
    }
    /**
     * cap nhat thong tin ban ghi
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function saveUpdate(Request $req)
    {
        $tr = new TagRequest;
        $validator = Validator::make($req->all(), $tr->rules($req), $tr->messages());
        $status = true;
        $tag =- null;
        $error = null;
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $status = false;
        }elseif(!($tag = $this->repository->updateTag($req->id, $req->tag))){
            $status = false;
            $error = "Lỗi không xác định vui lòng thử lại sau gây lát";
        }
        return response()->json(compact('status','tag','error'));
        
    }

}
