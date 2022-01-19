<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

//use App\Http\Requests\Pages\PageRequest;
use App\Repositories\Comments\CommentRepository;

use Cube\Html\Menu as HtmlMenu;

class CommentController extends AdminController
{
    //
    public $module = 'comment';
    public $route = 'admin.comment';
    public $folder = 'comments';
    public function __construct(CommentRepository $CommentRepository)
    {
        $this->repository = $CommentRepository;
        HtmlMenu::addActiveKey('admin_menu', $this->module);
    }


    /**
     * hien thi danh sach comment
     * @param  Request $request [description]
     * @return view             [description]
     */
    function list(Request $request) {
        $list = $this->repository->filter($request,'all');
        return $this->view('' . $this->module . '.list', compact('list'));
    }

    /**
     * hien thi danh sach comment
     * @param  Request $request [description]
     * @return view             [description]
     */
    function listOnPost(Request $request) {
        $list = $this->repository->filter($request,'post');
        return $this->view('' . $this->module . '.list', compact('list'));
    }

    /**
     * hien thi danh sach comment
     * @param  Request $request [description]
     * @return view             [description]
     */
    function listOnProduct(Request $request) {
        $list = $this->repository->filter($request,'product');
        return $this->view('' . $this->module . '.list', compact('list'));
    }

    /**
     * hien thi danh sach comment
     * @param  Request $request [description]
     * @return view             [description]
     */
    function listOnPage(Request $request) {
        $list = $this->repository->filter($request,'page');
        return $this->view('' . $this->module . '.list', compact('list'));
    }
    /**
     * hien thi danh sach comment
     * @param  Request $request [description]
     * @return view             [description]
     */
    function listOnDynamic(Request $request) {
        $list = $this->repository->filter($request,'dynamic');
        return $this->view('' . $this->module . '.list', compact('list'));
    }


    /**
     * hien thi danh sach comment
     * @param  Request $request [description]
     * @return view             [description]
     */
    function listHelp(Request $request) {
        $list = $this->repository->filter($request,'help');
        return $this->view('' . $this->module . '.list', compact('list'));
    }


    public function detail($id)
    {
        if(!($detail = $this->find($id)))
            return $this->view('errors.404');
        return $this->view('comment.detail',compact('detail'));
    }

    /**
     * xoa ban ghi
     * @param  Request $req [description]
     * @return json       [description]
     */
    public function approve(Request $req)
    {
        if (is_array($req->ids)) {
            $status = false;
            $list = [];
            foreach ($req->ids as $id) {
                if ($this->repository->approve($id)) {
                    $status = true;
                    $list[] = $id;
                }
            }
            return response()->json(compact('status', 'list'));
        } else {
            $status = $this->repository->approve($req->id);
            $id = $req->id;
            return response()->json(compact('status', 'id'));
        }
    }
    
    /**
     * xoa ban ghi
     * @param  Request $req [description]
     * @return json       [description]
     */
    public function unapprove(Request $req)
    {
        if (is_array($req->ids)) {
            $status = false;
            $list = [];
            foreach ($req->ids as $id) {
                if ($this->repository->unapprove($id)) {
                    $status = true;
                    $list[] = $id;
                }
            }
            return response()->json(compact('status', 'list'));
        } else {
            $status = $this->repository->unapprove($req->id);
            $id = $req->id;
            return response()->json(compact('status', 'id'));
        }
    }
    
}
