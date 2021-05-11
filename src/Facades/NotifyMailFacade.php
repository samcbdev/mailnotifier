<?php

namespace Samcb\MailNotifier\Facades;

use Illuminate\Support\Facades\Facade;

class NotifyMailFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Notifymail';
    }
}