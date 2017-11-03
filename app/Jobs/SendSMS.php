<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
// use App\Http\Controllers\Traits\SendsSMS;
use App\AfricasTalkingGateway;
use Illuminate\Support\Facades\Log;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $gateway;

    // africastalking credentials
    protected $username = 'sandbox';

    protected $key = '9ea2066025a3135671578adc0c46459bfbb510164b8852c5d27b050d41735449';

    // Sends to
    protected $recipients;

    // Message
    protected $message;

    // Results
    protected $sms_results;

    // Errors
    protected $sms_error;

    /**
     * 
     * @param type $phone_no
     * @param type $message
     */
    public function __construct($phone_no,$message)
    {
      $this->recipients = $phone_no;
      $this->message = $message;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
     protected function getInstance()
     {
       if (!$this->gateway) {
         $this->gateway = new AfricasTalkingGateway($this->username, $this->key,'sandbox');
       }
       return $this->gateway;
     }

    protected function sendMessage()
    {
      $gateway = $this->getInstance();

      try
        {
          $this->sms_results = $gateway->sendMessage($this->recipients, $this->message);

          return true;
        }
        catch ( AfricasTalkingGatewayException $e )
        {
          $this->sms_error = "Encountered an error while sending: ".$e->getMessage();

          return false;
        }
    }

    public function handle()
    {
        return $this->sendMessage();
    }
}
