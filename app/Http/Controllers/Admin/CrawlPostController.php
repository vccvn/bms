<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Crawl\CrawlPostRepository;
use App\Repositories\Crawl\FrameRepository;
use App\Repositories\Crawl\TaskRepository;
use App\Http\Requests\Crawl\FrameRequest;
use App\Http\Requests\Crawl\CrawlPostRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

use Redirect;
class CrawlPostController extends AdminController
{
	public $module = 'crawler';
	public $route = 'admin.crawler.post';
	public $folder = 'crawler';

    public function __construct(CrawlPostRepository $CrawlPostRepository, FrameRepository $FrameRepository)
    {
        $this->repository = $CrawlPostRepository;
        $this->frames = $FrameRepository;
        HtmlMenu::addActiveKey('admin_menu','crawler');
    }
    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Craw Post";
        $btnTxt = "Crawl";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'url,dynamic_id,cate_id,user_id,frame_id';
        
        $form_title=$btnTxt.' Post';
        
        $data = compact('title','form_title','form_action', 'form_id');
        
        return $this->showForm('crawl.post.form','crawl-post',$inputList,$model,$data,$btnTxt);
    }

    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(CrawlPostRequest $request)
    {
        if($post = $this->repository->crawl($request->all())){
            if($post->type=='dynamic'){
                redirect()->route('admin.dynamic.item',['slug'=>$post->parent->slug]);
            }
            return redirect()->route('admin.post.list');
        }
        // if($this->repository->saveFrame($request)){
        //     return redirect()->route($this->route.'.list');
        // }
        return Redirect::back()->withInput($request->all());
    }


}
