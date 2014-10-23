<?php namespace Modules\User\Commands;

use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Event;
use Laracasts\Commander\CommandHandler;
use Modules\User\Events\UserHasBegunResetProcess;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\Repositories\UserRepository;

class BeginResetProcessCommandHandler implements CommandHandler
{
    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the command
     *
     * @param $command
     * @throws UserNotFoundException
     * @return mixed
     */
    public function handle($command)
    {
        $user = $this->findUser((array) $command);

        $reminder = Reminder::exists($user) ?: Reminder::create($user);

        Event::fire('Modules.User.Events.UserHasBegunResetProcess', new UserHasBegunResetProcess($user, $reminder));
    }

    private function findUser($credentials)
    {
        $user = $this->user->findByCredentials((array) $credentials);
        if ($user) {
            return $user;
        }

        throw new UserNotFoundException();
    }
}
