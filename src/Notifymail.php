<?php

namespace Samcb\MailNotifier;

use Samcb\MailNotifier\Models\NotifyMail as NotifymailModel;
use Samcb\MailNotifier\Http\Controllers\NotifyMailController;

class Notifymail
{
    public function generate_records($template_unique_id,$replace_array_content,$replace_array_subject=NULL)
    {
        $get=new NotifyMailController;
        $set=$get->key_modify($template_unique_id,$replace_array_content,$replace_array_subject);
        return $set;
    }

    public function send_mail($details)
    {
        $get=new NotifyMailController;
        $set=$get->send_mail($details);
        return $set;
    }

    public function check_dynamic_fields($template_unique_id)
    {
        $get=new NotifyMailController;
        $set=$get->check_fields($template_unique_id);
        return $set;
    }
}
