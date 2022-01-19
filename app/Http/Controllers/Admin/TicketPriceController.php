<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Repositories\Tickets\TicketPriceRepository;
use App\Http\Requests\Tickets\TicketPriceRequest;
use Carbon\Carbon;
use Session;

use Cube\Html\Menu as HtmlMenu;

use Cube\Files;

use Cube\Html\Input;

class TicketPriceController extends AdminController
{
	public $module = 'ticket-price';
	public $route = 'admin.ticket.price';
	public $folder = 'ticket-price';

    public function __construct(TicketPriceRepository $TicketPriceRepository)
    {
        $this->repository = $TicketPriceRepository;
        HtmlMenu::addActiveKey('admin_menu','ticket-price');
        
        parent::__construct();
    }

    /**
     * hien thi danh sach nguoi dung
     * @param  Request $request [description]
     * @return view           [description]
     */
    public function list(Request $request)
    {
        $list = $this->repository->filter($request);
        $data = compact('list');

        return $this->view('ticket.price-list',$data);
        
    }

    /**
     * hien thi form
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function form($id=null)
    {
        $model = null;
        $title = "Giá vé";
        $btnTxt = "Thêm";
        $form_action = $this->route.'.save';
        $form_id = $this->module.'-form';
        $inputList = [
            "company_id","route_id","price"
        ];
        if($id){
            if($m = $this->repository->find($id)){
                $model = $m;
                $btnTxt = "Cập nhật";
            }
            else{
                return $this->view('errors.404');
            }
        }
        $form_title=$btnTxt.' '.$title;
        
        $data = compact('title','form_title','form_action', 'form_id');
        
        return $this->showForm('forms.second',$this->module,$inputList,$model,$data,$btnTxt);
    }

    /**
     * cap nhat thong tin
     * @param  Request $req [description]
     * @return Reponse       [description]
     */
    public function save(TicketPriceRequest $request)
    {
        if($this->repository->save($request->all(), $request->id)){
            return redirect()->route($this->route.'.list');
        }
        return redirect()->back()->withInputs($request->all());
    }

}
