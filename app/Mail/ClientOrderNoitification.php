<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Web\Siteinfo;
use App\Web\Setting;

class ClientOrderNoitification extends Mailable
{
    use Queueable, SerializesModels;

    protected $content;
    
    protected $siteinfo;
    protected $setting;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content){
        //
        $this->content = $content;
        $this->siteinfo = new Siteinfo();
        $this->setting = new Setting();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$email = $this->setting->email_get_data?$this->setting->email_get_data:'doanln16@gmail.com';
        $from = $this->setting->email?$this->setting->email:'doanln16@gmail.com';
        //$admin = $email;
        return $this->from($from, $this->siteinfo->site_name)
        ->subject('Bạn vừa đặt hàng thành công trên website '.$this->siteinfo->site_name)
        ->view('mail.noitifications.message')->with([
            'content' => $this->content
        ]);
    }
}
