<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

//use App\Http\Requests\Pages\PageRequest;
use App\Repositories\Contacts\ContactRepository;


use App\Repositories\Contacts\ContactReplyRepository;
use App\Http\Requests\Contacts\ContactReplyRequest;

use Cube\Html\Menu as HtmlMenu;
use Cube\Email;
use App\Web\Siteinfo;

class ContactController extends AdminController
{
    //
    public $module = 'contact';
    public $route = 'admin.contact';
    public $folder = 'contacts';
    public function __construct(ContactRepository $contactRepository, ContactReplyRepository $contactReplyRepository)
    {
        $this->repository = $contactRepository;
        $this->replyRepository = $contactReplyRepository;
        HtmlMenu::addActiveKey('admin_menu', $this->module);
    }


    /**
     * hien thi danh sach comment
     * @param  Request $request [description]
     * @return view             [description]
     */
    function list(Request $request) {
        $list = $this->repository->filter($request);
        return $this->view($this->module . '.list', compact('list'));
    }


    public function detail($id)
    {
        if(!($detail = $this->find($id)))
            return $this->view('errors.404');
        return $this->view($this->module . '.detail',compact('detail'));
    }

    public function sendReply(ContactReplyRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        if($m = $this->replyRepository->save($data)){
            $siteinfo = new Siteinfo();
            $contact = $this->find($request->contact_id);
            $content = $m->content;
            $reply = compact('siteinfo','contact','content');
            $stt = Email::from($siteinfo->email, $siteinfo->site_name)
                ->to($contact->email, $contact->name)
                ->replyTo('no-reply@lightsolution.vn')
                ->subject($siteinfo->site_name.' trả lời liên hệ')
                ->body('mail.contact-reply')
                ->data($reply)
                ->send();
            return redirect()->back()->with('success', $stt);
        }
        return redirect()->back()->with('fail', true)->withInputs($request->all());
    }
}
