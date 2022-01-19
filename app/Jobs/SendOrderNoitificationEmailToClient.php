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


use App\Mail\AdminOrderNoitification;
use App\Mail\ClientOrderNoitification;

class SendOrderNoitificationEmailToClient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $content;
    
    protected $siteinfo;
    protected $setting;
    public $tries = 5;
    public $timeout = 120;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $content)
    {
        $this->email = $email;
        $this->content = $content;
        
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
        $email = $this->email;

        echo 'Start send email: '.$email."\n";
        try{
            $clientEmail = new ClientOrderNoitification($this->content);
            Mail::to($email)->send($clientEmail);
                  
        
        }
        catch(exception $e){
            echo $e->getMessage()."\n";
        }
        
        echo 'End send email';
    }
}
