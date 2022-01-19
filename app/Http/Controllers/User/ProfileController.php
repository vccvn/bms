<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Repositories\Users\UserRepository;

use Cube\Html\Menu as HtmlMenu;

class ProfileController extends UserController
{
        //
        public $module = 'profile';
        public $route = 'user.profile';
        public $folder = 'users';
    
        public function __construct(UserRepository $userRepository)
        {
            $this->userRepository = $userRepository;
            HtmlMenu::addActiveKey('proile_menu',$this->module);
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
         * @return [type] [description]
         */
        public function index(Request $request)
        {
            $profile = $request->user();
            return $this->view('profile.index',compact('profile'));
        }
}
