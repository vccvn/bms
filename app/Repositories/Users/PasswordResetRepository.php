<?php

namespace App\Repositories\Users;

/**
 * @created doanln  2018-10-27
 */
use App\Repositories\EloquentRepository;

use App\Models\PasswordReset;
use DB;
class PasswordResetRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PasswordReset::class;
    }

    public function getForgotMail($email=null)
    {
        return PasswordReset::where('email', $email)->first();
    }

    public function getForgotToken($token=null)
    {
        return PasswordReset::where('token', $token)->first();
    }

    public function saveToken($email,$token,$datetime)
    {
        $forgot = $this->getForgotMail($email);
        if($forgot){
            DB::table('password_resets')->where('email', $email)
                ->update([
                    'token' => $token,
                    'created_at' => $datetime
                ]);
        }else{
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => $datetime
            ]);
        }

    }

    public function isToken($token)
    {
        return $this->_model->isToken($token);

    }

}