<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\WebOptions\WebOptionRepository;

use Cube\Html\Menu as HtmlMenu;

use App\Http\Requests\WebOptions\SaveOptionRequest;
use App\Http\Requests\WebOptions\AddOptionRequest;

use Validator;


class WebOptionController extends AdminController
{
	public $module = 'option';
	public $route = 'admin.option';
	public $folder = 'options';


    protected $option_groups = [
        'siteinfo' => 'Thông tin site',
        'setting' => 'Cài đặt',
        'data' => 'Dữ liệu',
        'embed' => 'Mã nhúng'
    ];
    public function __construct(WebOptionRepository $WebOptionRepository)
    {
        $this->repository = $WebOptionRepository;
        HtmlMenu::addActiveKey('admin_menu','option');
    }


    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request, $option_group)
    {
        $s = $request->s;
    	$inputData = $this->repository->form($option_group, $s,'name');
        $model = null;
        $title = isset($this->option_groups[$option_group])?$this->option_groups[$option_group]:"Tùy chọn";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $data = compact('title','form_action', 'form_id','option_group');
        
        return $this->showForm($this->module.'.form',$inputData,'*',$model,$data,"Cập nhật");
    }

    public function add(Request $request)
    {
        $status = true;
        $item = null;
        $error = null;
        $aor = new AddOptionRequest();
        $validator = Validator::make($request->all(), $aor->rules(), $aor->messages());
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $status = false;
        }elseif(!($item = $this->repository->addItem($request->option_group, $request->name,$request->type,null,$request->comment))){
            $status = false;
            $error = "Lỗi không xác định vui lòng thử lại sau gây lát";

        }
        return response()->json(compact('status','item','error'));
    }
    /**
     * cap nhat thong tin nguoi dung
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(SaveOptionRequest $request)
    {
        $g = $request->option_group;
        if($notfile = $this->repository->listNotFileField($g)){
            foreach ($notfile as $field) {
                $val = $request->{$field};
                if($val !== null){
                    $this->repository->saveValue($g,$field,$val);
                }
            }
        }
        if($listFile = $this->repository->listFileField($g)){
            foreach ($listFile as $field) {
                if($request->hasFile($field)){
                    $file = $request->file($field);
                    $ext = strtolower($file->getClientOriginalExtension());
                    $filename = $field.'.'.$ext;
                    $mime = $file->getClientMimeType();
                    $destinationPath = public_path('/contents/'.$this->folder.'/'.$g);
                    $file->move($destinationPath, $filename);
                    $this->repository->saveValue($g,$field,$filename);
                }
            }
        }
        return redirect()->route($this->route.'.group',['option_group' => $g]);
    }

}
