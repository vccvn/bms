<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use Mail;
use Cube\Email;
use App\Models\Order;

use App\Web\Siteinfo;
use App\Web\Setting;


use App\Mail\AdminOrderNoitification;
use App\Mail\ClientOrderNoitification;

class SendOrderNoitificationEmailToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $siteinfo;
    protected $setting;
    public $tries = 5;
    public $timeout = 120;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->siteinfo = new Siteinfo();
        $this->setting = new Setting();
    }
    public function retryUntil()
    {
        return now()->addSeconds(30);
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $order = $this->order;
        $email = $this->setting->email_get_data?$this->setting->email_get_data:'doanln16@gmail.com';
        echo 'Start send email: '.$email."\n";
        try{
            $adminEmail = new AdminOrderNoitification($order);
            Mail::to($email)->send($adminEmail);        
        }
        catch(exception $e){
            echo $e->getMessage()."\n";
        }
        
        echo 'End send email';
    }
}
