<?php

namespace Samcb\MailNotifier\Models;

use Illuminate\Database\Eloquent\Model;

class NotifyMail extends Model
{
    protected $guarded = [];

    public function getTable()
    {
        return config('notifymail.table_name');
    }
}