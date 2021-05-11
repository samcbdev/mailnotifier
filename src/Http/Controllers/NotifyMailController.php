<?php

namespace Samcb\MailNotifier\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Samcb\MailNotifier\Jobs\NotifyMailJob;

class NotifyMailController extends Controller
{
    public function key_modify($id,$replace_array_content,$replace_array_subject){
    	$mail=DB::table(config('notifymail.table_name'))->where('id',$id)->first();
    	$mail_content=$mail->content;
    	$mail_subject=$mail->subject;

    	$dynamic_fields_content=[];
    	$dynamic_fields_subject=[];

        if (preg_match_all('/{([^}]*)}/', $mail->content, $matches, PREG_OFFSET_CAPTURE)) {
		        foreach ($matches[1] as $match) {
		            $dynamic_fields_content[]= "{". "{$match[0]}" ."}";
		        }
		}

		if (preg_match_all('/{([^}]*)}/', $mail->subject, $matches, PREG_OFFSET_CAPTURE)) {
		        foreach ($matches[1] as $match) {
		            $dynamic_fields_subject[]= "{". "{$match[0]}" ."}";
		        }
		}

		return $this->replace_data($dynamic_fields_content,$dynamic_fields_subject,$mail_content,$mail_subject,$replace_array_content,$replace_array_subject);
    }

    public function replace_data($dynamic_fields_content,$dynamic_fields_subject,$mail_content,$mail_subject,$replace_array_content,$replace_array_subject){

    	$details=array(
    		'subject'=>'',
    		'content'=>''
    	);

    	$chk_dynamic_subject= count($dynamic_fields_subject);
    	if ($chk_dynamic_subject>0) {
    		$dynamic_fields_subject = array_values(array_unique($dynamic_fields_subject));
    		$combied_array_subject= array_combine($dynamic_fields_subject,$replace_array_subject);

    		$subject=strtr($mail_subject,$combied_array_subject);
    		//return $subject;
    		$details['subject']=$subject;
    	}
    	else{
    		//return $mail_subject;
    		$details['subject']=$mail_subject;
    	}

    	$chk_dynamic_content= count($dynamic_fields_content);
    	if ($chk_dynamic_content>0) {
    		$dynamic_fields_content = array_values(array_unique($dynamic_fields_content));
    		$combied_array_content= array_combine($dynamic_fields_content,$replace_array_content);

    		$message=strtr($mail_content,$combied_array_content);
    		//return $message;
    		$details['content']=$message;
    	}
    	else{
    		//return $mail_content;
    		$details['content']=$mail_content;
    	}

    	return $this->generate_details($details);
    }

    public function generate_details($details){
    	$details=$details;
    	return $details;
    }

    public function send_mail($details){
    	return NotifyMailJob::dispatch($details);
    }

    public function check_fields($id){
    	$mail=DB::table(config('notifymail.table_name'))->where('id',$id)->first();
    	$retrieve=[];

    	$dynamic_fields_content=[];
    	if (preg_match_all('/{([^}]*)}/', $mail->content, $matches, PREG_OFFSET_CAPTURE)) {
		        foreach ($matches[1] as $match) {
		            $dynamic_fields_content[]= "{". "{$match[0]}" ."}";
		        }
		}

		$chk_dynamic_content= count($dynamic_fields_content);
    	if ($chk_dynamic_content>0) {
    		$dynamic_fields_content=array_unique($dynamic_fields_content);
    		$retrieve['content']=$dynamic_fields_content;
    		//return $dynamic_fields_content;
    	}
    	else{
    		$retrieve['content']="There is no dynamic fields.";
    	}

    	$dynamic_fields_subject=[];
    	if (preg_match_all('/{([^}]*)}/', $mail->subject, $matches, PREG_OFFSET_CAPTURE)) {
		        foreach ($matches[1] as $match) {
		            $dynamic_fields_subject[]= "{". "{$match[0]}" ."}";
		        }
		}

		$chk_dynamic_subject= count($dynamic_fields_subject);
    	if ($chk_dynamic_subject>0) {
    		$dynamic_fields_subject=array_unique($dynamic_fields_subject);
    		$retrieve['subject']=$dynamic_fields_subject;
    		//return $dynamic_fields_content;
    	}
    	else{
    		$retrieve['subject']="There is no dynamic fields.";
    	}

    	return $retrieve;
    }
}