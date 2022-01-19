<?php
namespace Cube;

use Illuminate\Support\Facades\Mail;

class Gmail{
	public static $to = null;
	public static $CC = null;
	public static $BCC = null;
	public static $subject = null;
	
	public static function send($to,$subject='',$body='', $var = array(), $attachments = null) {
		self::$subject = $subject;
		if(is_string($to) && filter_var($to, FILTER_VALIDATE_EMAIL)){
			self::$to = $to;
		}elseif(is_array($to)){
			foreach($to as $key => $val){
				if(is_numeric($key)){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						self::$to[] = $val;
					}
				}elseif (strtolower($key) == '@cc') {//neu co CC
					self::$CC = $val;
				}elseif (strtolower($key) == '@bcc') {// neu co BCC
					self::$BCC = $val;
				}else{
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						self::$to[$val] = $key;
					}elseif(filter_var($key, FILTER_VALIDATE_EMAIL)){
						self::$to[$key] = $val;
					}
				}
			}
		}
		
		Mail::send($body, $var, function ($message) {
			$TO = \Cube\Gmail::$to;
			if(is_string($TO) && filter_var($TO, FILTER_VALIDATE_EMAIL)){
				$message->to($TO, 'Guest');
			}elseif(is_array($CC)){
				foreach($TO as $key => $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$message->to($val, 'Guest');
					}else{
						$message->to($key, $val);
					}
				}
			}
			$CC = \Cube\Gmail::$CC;

			if(is_string($CC) && filter_var($CC, FILTER_VALIDATE_EMAIL)){
				$message->cc($CC);
			}elseif(is_array($CC)){
				foreach($CC as $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$message->cc($val);
					}
				}
			}
			$BCC = \Cube\Gmail::$BCC;
			if(is_string($BCC) && filter_var($BCC, FILTER_VALIDATE_EMAIL)){
				$message->bcc($BCC);
			}elseif(is_array($BCC)){
				foreach($BCC as $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$message->bcc($CC);
					}
				}
			}
			
			//$message->to('thienth32@gmail.com', 'Thien tran');
			//$message->cc('kenjav96@gmail.com', 'Dũng thần dâm');
			$message->replyTo('doanlnph04866@fpt.edu.vn', 'Mr.Doan');
			$message->from('doanlnph04866@fpt.edu.vn', 'Mr.Doan');
			
			$message->subject(\Cube\Gmail::$subject);
		});
		return true;
	}
}





