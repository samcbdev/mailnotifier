<?php

namespace Samcb\MailNotifier\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Samcb\MailNotifier\Mail\NotifyMail;
use Mail;

class NotifyMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
       $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $email = new NotifyMail($this->details);
       $emailtemplate = $this->details;

        $cc_mail_str = str_replace(" ",'',$emailtemplate['cc_mail']);
        $cc_mail=explode(",",$cc_mail_str);
        $cc_mail= array_filter($cc_mail);

        $bcc_mail_str = str_replace(" ",'',$emailtemplate['bcc_mail']);
        $bcc_mail=explode(",",$bcc_mail_str);
        $bcc_mail= array_filter($bcc_mail);

        if(count($cc_mail)>0 && count($bcc_mail)>0 ){

            Mail::to($emailtemplate['email'])->cc($cc_mail)->bcc($bcc_mail)->send($email);
        }

        else if(count($cc_mail)>0 && count($bcc_mail)==0 ){

            Mail::to($emailtemplate['email'])->cc($cc_mail)->send($email);
        }

        else if(count($bcc_mail)>0 && count($cc_mail)==0 ){

            Mail::to($emailtemplate['email'])->bcc($bcc_mail)->send($email);
        }
        else{
            
            Mail::to($emailtemplate['email'])->send($email);
        }

    }
}
