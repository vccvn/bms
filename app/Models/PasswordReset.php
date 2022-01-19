<?php

namespace App\Models;



use Carbon\Carbon;

class PasswordReset extends Model
{
    //
    //
    public function isToken($token)
    {
        if($PR = self::where('token', $token)->first()){
            $created = Carbon::parse($PR->created_at);
            $now = Carbon::now();
            if($now->diffInDays($created) == 0){
                return true;
            }
        }

        return false;

    }
}
