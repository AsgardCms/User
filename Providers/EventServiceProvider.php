<?php namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\User\Events\UserHasRegistered' => [
            'Modules\User\Events\Handlers\SendRegistrationConfirmationEmail',
        ],
        'Modules\User\Events\UserHasBegunResetProcess' => [
            'Modules\User\Events\Handlers\SendResetCodeEmail',
        ],
    ];
}
