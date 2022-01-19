<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Crawl\CrawlPostRepository;
use App\Repositories\Crawl\FrameRepository;
use App\Repositories\Crawl\TaskRepository;
use App\Http\Requests\Crawl\FrameRequest;
use App\Http\Requests\Crawl\TaskRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

class CrawlTaskController extends AdminController
{
	public $module = 'crawler';
	public $route = 'admin.crawler.task';
	public $folder = 'crawler';

    public function __construct(TaskRepository $TaskRepository, FrameRepository $FrameRepository, CrawlPostRepository $CrawlPostRepository)
    {
        $this->repository = $TaskRepository;
        $this->frames = $FrameRepository;
        $this->posts = $CrawlPostRepository;
        HtmlMenu::addActiveKey('admin_menu','crawler');
    }

    public function index(Request $request)
    {
        $list = $this->repository->filter($request);
        return $this->view('crawl.task.list',compact('list'));
    }


    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Craw Task";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = 'url,url_post,quantity,repeat_time,crawl_time,run_time,dynamic_id,cate_id,user_id,frame_id,status';
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $btnTxt = "Cập nhật";
            }
            else{
                return $this->view('errors.404');
            }
        }
        $form_title=$btnTxt.' task';
        
        $data = compact('title','form_title','form_action', 'form_id');
        
        return $this->showForm('crawl.task.form','crawl-task',$inputList,$model,$data,$btnTxt);
    }

    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(TaskRequest $request)
    {
        $data = $request->all();
        $data['run_time'] = $request->run_time == 'on' ? 1 : 0;
        $data['crawl_last_time'] = date('G:i:s', time());
        
        if($this->repository->save($data,$request->id)){
            return redirect()->route($this->route.'.list');
        }
        return redirect()->back()->withInputs($request->all());
    }

    public function changeStatus(Request $request)
    {
        $status = false;
        $task = null;
        $id = $request->id;
        $status = $request->status;
        if($id && $this->repository->find($id) && in_array($status,[1,0])){
            if($s = $this->repository->save(['status' => $status], $id)){
                $status = true;
                $s->status = $status;
                $task = $s;
            }
        }
        return response()->json(compact('status','task'));
    }


    public function run(REquest $request){
        set_time_limit(0);
        $status = false;
        $count = 0;
        if(is_array($request->ids) && count($request->ids)){
            foreach ($request->ids as $id) {
                $c = $this->repository->run($id);
                if($c){
                    $count += $c;
                    $status = true;
                    
                }
            }
        }
        
        Session::flash('count', $count);
        return response()->json(compact('status','count'));
    }
}
