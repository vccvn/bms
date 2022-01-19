<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use Redirect;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\PasswordResetRepository;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Requests\Users\SaveResetPasswordRequest;

use Carbon\Carbon;
use Cube\Email;

use App\Web\Setting;
use App\Http\Controllers\Controller;
class AuthController extends Controller
{
    //
    protected $name = 'users';

    public $table = 'users';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
     
    public function __construct(UserRepository $userRepository, PasswordResetRepository $passwordResetRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->userRepository = $userRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    public function register()
    {
        $title = "Đăng ký tài khoản mới";
        $inputList = 'name,email,username,password,password_confirmation';
        $form_action = $form_type = 'register';
        $form_id = 'signup2-form';
        $data = compact('title','inputList','form_action','form_id');
        return $this->showForm('user.auth.form','user',$inputList,null,$data,"Đăng ký");
    }

    public function postRegister(RegisterRequest $req)
    {
        $data = $req->all();
        $this->userRepository->save($data);
        return redirect()->route('login')->with('register','Đăng ký tài khoản thành công');
    }


    public function login()
    {
        $title = "Đăng nhập";
        $inputList = 'username,password';
        $form_action = $form_type = 'login';
        $form_id = 'login2-form';
        $data = compact('title','inputList','form_action','form_id');
        return $this->showForm('user.auth.form','user',$inputList,null,$data,"Đăng nhập");
    }

    public function postLogin(LoginRequest $req)
    {
        $arg1 = [
            'status'=>200,
            'username' => $req->username,
            'password' => $req->password,
        ];
        $arg2 = [
            'status'=>200,
            'email' => $req->username,
            'password' => $req->password,
        ];
        if(Auth::attempt($arg1,$req->remember) || Auth::attempt($arg2,$req->remember)){
            $user = Auth::user();
            if($user->hasOnly(['access','barie'])){
                return redirect()->intended(route('admin.checkin'));
            }
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->route('login')->withInput($req->all())->with('error','Sai tài khoản hoặc mật khẩu');
        
    }

    public function forgot()
    {
        $title = "Quên mật khẩu";
        $inputList = 'email';
        $form_action = 'forgot';
        $form_type = 'forgot';
        $form_id = 'reset-form';
        $data = compact('title','inputList','form_action','form_id');
        return $this->showForm('user.auth.form','user',$inputList,null,$data,"Lấy lại mật khẩu");
    }

    public function postForgot(Request $request)
    {
        $request->validate(['email'=>'required|email']);

        if($user = $this->userRepository->findBy('email',$request->email)){
            $email = $user->email;
            $name = $user->name;
            $token = strtolower(str_random(64));
            $now = Carbon::now();
            
            $this->passwordResetRepository->saveToken($email,$token,$now);
            $link = route('user.password.reset',compact('token'));
            $company = "Tuoi Tieu";
            $setting = new Setting();
            Email::from($setting->email,$setting->company)
                ->to($email,$name)
                ->subject('Tạo lại mật khẩu tại '.$setting->company)
                ->body('mail.forgot')
                ->data(compact('name','email','link','company','setting'))
                ->send();
        }

        return $this->alert(
                    'Yêu cầu đặt lại mật khẩu của bạn đã dược chấp nhận. Vui lòng kiểm tra email để đặt lại mật khẩu',
                    'success'
                );

    }


    public function resetPasswordViaMailToken($token)
    {
        if($this->passwordResetRepository->isToken($token)){

            $title = "Đặt lại mật khẩu";
            $inputList = 'token,password,password_confirmation';
            $form_action = 'user.password.reset.save';
            $form_type = 'reset';
            $form_id = 'reset-password-form';
            $form_data = compact('token');
            $data = compact('title','inputList','form_action','form_id');
            return $this->showForm('user.auth.form','user',$inputList,$form_data,$data,"Lấy lại mật khẩu");
        }
        return $this->alert(
            'Đường dẫn không hợp lệ hoặc đã quá hạn sự dụng. 
            Vui lòng gửi lại yêu cầu lấy lại mật khẩu lần nữa',
            'warning',
            route('forgot'),
            'Gửi lại yêu cầu'
        );
    }

    public function savePasswordViaMailToken(SaveResetPasswordRequest $request)
    {
        if($this->passwordResetRepository->isToken($request->token)){
            $forgot = $this->passwordResetRepository->getForgotToken($request->token);

            if($user = $this->userRepository->findBy('email',$forgot->email)){
                $password = $request->password;
                $this->userRepository->save(compact('password'),$user->id);
                return $this->alert(
                    'Bạn đã đặt lại mật khẩu thành công. Vui lòng đăng nhập để tiếp tục!',
                    'success',
                    route('login'),
                    'Đăng nhập'
                );
            }
        }
        return $this->alert('Đường dẫn không hợp lệ hoặc đã quá hạn sự dụng. Vui lòng gửi lại yêu cầu lấy lại mật khẩu lần nữa','warning');
    }



    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


    /**
     * hien thi thong bao. chen link nếu có
     * @param  string $message noi dung thong bao
     * @param  string $type    kieu thong bao (bootstrap)
     * @param  string $link    duong dan
     * @param  string $text    text
     * @return view            view
     */
    public function alert($message=null,$type='success',$link=null,$text=null)
    {
        return view('user.message',compact('message','type','link','text'));
    }
}
