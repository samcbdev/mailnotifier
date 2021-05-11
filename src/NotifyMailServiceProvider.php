<?php

namespace Samcb\MailNotifier;

use Illuminate\Support\ServiceProvider;

class NotifyMailServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishResources();
        }
        $this->loadViewsFrom(__DIR__.'/resources/views', 'notifyblade');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/notifymail.php', 'notifymail');

        $this->app->bind('Notifymail', function () {
            return new Notifymail();
        });
    }

    protected function publishResources()
    {
        $this->publishes([
            __DIR__ . '/config/notifymail.php' => config_path('notifymail.php'),
        ], 'notifymail-config');

        $this->publishes([
            __DIR__ . '/database/migrations/create_email_notifications_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_email_notifications_table.php'),
        ], 'notifymail-migrations');
    }
}