<?php

namespace App\Support;

use Illuminate\Notifications\Notifiable;

class EmailNotifiable
{
    use Notifiable;

    public function __construct(
        protected string $email
    ) {
    }

    public function routeNotificationForMail(): string
    {
        return $this->email;
    }
}
