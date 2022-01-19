<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;

use App\Http\Requests\Users\GeneralRequest;

use App\Http\Requests\Users\AccountRequest;

use App\Http\Requests\Users\PasswordRequest;




use Cube\Html\Menu as HtmlMenu;

use Validator;

use Hash;

class SettingController extends UserController
{
    //
    public $module = 'setting';
	public $route = 'user.profile.setting';
	public $folder = 'users';

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        HtmlMenu::addActiveKey('proile_menu',$this->module);

        Validator::extend('password_match', function($attr, $value){
            $password = auth()->user()->password;
            return Hash::check($value,$password);
        });
        Validator::extend('is_phone_number', function($attr, $value){
            return preg_match('/^(\+84|0)+[0-9]{9,10}$/si', $value);
        });
    }

    /**
     * tim mot nguoi dung thong qua id
     * @param  integer $id [description]
     * @return model     [description]
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }
    /**
     * hien thi trang chu cua module user
     * @return View
     */
    public function index(Request $request)
    {
        $profile = $request->user();
        return view('user.profile.general',compact('profile'));
    }

    /**
     * hien thi form
     * @return View
     */
    public function general(Request $request)
    {
        $profile = $request->user();
        $profile->applyMeta();
        return view('user.profile.general',compact('profile'));
    }

    public function saveGeneral(GeneralRequest $request)
    {
        
        $data = [
            'name' => $request->name,
        ];
        $id = $request->user()->id;
        $this->userRepository->save($data,$id);
        $this->userRepository->saveMetaSimple($id, 'job', $request->job);
        $this->userRepository->saveMetaSimple($id, 'work', $request->work);
        
        return redirect()->route('user.profile.setting.general')->with('alert',"Cập nhật thông tin thành công!");
    }


    /**
     * hien thi form
     * @return View
     */
    public function account(Request $request)
    {
        $profile = $request->user();
        return view('user.profile.account',compact('profile'));
    }

    public function saveAccount(AccountRequest $request)
    {
        $id = $request->user()->id;
        $data = [
            'username' => $request->username,
            'email' => $request->email,
       ];

        $this->userRepository->save($data,$request->user()->id);
        return redirect()->route('user.profile.setting.account')->with('alert',"Cập nhật thông tin tài khoản thành công!");
    }


    /**
     * hien thi form
     * @return View
     */
    public function password(Request $request)
    {
        $profile = $request->user();
        return view('user.profile.password',compact('profile'));
    }

    public function savePassword(PasswordRequest $request)
    {
        $data = [
            'password' => $request->new_password
        ];

        $this->userRepository->save($data,$request->user()->id);
        return redirect()->route('user.profile.setting.password')->with('alert',"Cập nhật thông tin mật khẩu thành công!");
    }


    /**
     * hien thi form
     * @return View
     */
    public function avatar(Request $request)
    {
        $profile = $request->user();
        return view('user.profile.avatar',compact('profile'));
    }

    public function saveAvatar(Request $request)
    {
        $id = $request->user()->id;
        $field = 'avatar';
        $newAvatar = null;
        if($request->image_data){
            $output = save_base64_image($request->image_data, $id, '/contents/users/avatar/' );
            $newAvatar = $output?$output:null;
        }elseif($request->hasFile($field)){
            $request->validate([
                'avatar' => 'mimes:jpeg,png,jpg,gif'
                
            ],[
                'avatar.mimes' => 'Định dạng ảnh không hợp lệ'
            ]);    
            $file = $request->file($field);
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = $id.'.'.$ext;
            $mime = $file->getClientMimeType();
            $destinationPath = public_path('/contents/users/avatar');
            $file->move($destinationPath, $filename);
            $newAvatar = $filename;
        }
        if($newAvatar && $this->userRepository->saveMetaSimple($id,'avatar', $newAvatar)){
            return redirect()->route('user.profile.setting.avatar')->with('alert',"Cập nhật Ảnh dại diện thành công!");
        }
        
        return redirect()->route('user.profile.setting.avatar');
    }
}
