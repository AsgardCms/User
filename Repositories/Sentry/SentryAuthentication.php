<?php namespace Modules\User\Repositories\Sentry;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Modules\Core\Contracts\Authentication;
use Modules\User\Events\UserHasActivatedAccount;

class SentryAuthentication implements Authentication
{
    /**
     * Authenticate a user
     * @param  array $credentials
     * @param  bool  $remember    Remember the user
     * @return mixed
     */
    public function login(array $credentials, $remember = false)
    {
        try {
            Sentry::authenticate($credentials, $remember);

            return false;
        } catch (LoginRequiredException $e) {
            return 'Login field is required.';
        } catch (PasswordRequiredException $e) {
            return 'Password field is required.';
        } catch (WrongPasswordException $e) {
            return 'Wrong password, try again.';
        } catch (UserNotFoundException $e) {
            return 'User was not found.';
        } catch (UserNotActivatedException $e) {
            return 'User is not activated.';
        } catch (UserSuspendedException $e) {
            return 'User is suspended.';
        } catch (UserBannedException $e) {
            return 'User is banned.';
        }
    }

    /**
     * Register a new user.
     * @param  array $user
     * @return bool
     */
    public function register(array $user)
    {
        return Sentry::register($user);
    }

    /**
     * Activate the given used id
     * @param  int    $userId
     * @param  string $code
     * @return bool
     */
    public function activate($userId, $code)
    {
        $user = Sentry::findUserById($userId);

        try {
            $success = $user->attemptActivation($code);
            if ($success) {
                event(new UserHasActivatedAccount($user));
            }

            return $success;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Assign a role to the given user.
     * @param  \Modules\User\Repositories\UserRepository $user
     * @param  \Modules\User\Repositories\RoleRepository $role
     * @return mixed
     */
    public function assignRole($user, $role)
    {
        return $role->users()->attach($user);
    }

    /**
     * Log the user out of the application.
     * @return mixed
     */
    public function logout()
    {
        return Sentry::logout();
    }

    /**
     * Create an activation code for the given user
     * @param $user
     * @return mixed
     */
    public function createActivation($user)
    {
        return $user->getActivationCode();
    }

    /**
     * Create a reminders code for the given user
     * @param $user
     * @return mixed
     */
    public function createReminderCode($user)
    {
        return $user->getResetPasswordCode();
    }

    /**
     * Completes the reset password process
     * @param $user
     * @param  string $code
     * @param  string $password
     * @return bool
     */
    public function completeResetPassword($user, $code, $password)
    {
        return $user->attemptResetPassword($code, $password);
    }

    /**
     * Determines if the current user has access to given permission
     * @param $permission
     * @return bool
     */
    public function hasAccess($permission)
    {
        $user = Sentry::getUser();

        if (is_null($user)) {
            return false;
        }

        return $user->hasAccess($permission);
    }

    /**
     * Check if the user is logged in
     * @return mixed
     */
    public function check()
    {
        if (Sentry::check()) {
            return Sentry::getUser();
        }

        return false;
    }

    /**
     * Get the ID for the currently authenticated user
     * @return int
     */
    public function id()
    {
        if (! $user = $this->check()) {
            return;
        }

        return $user->id;
    }
}
