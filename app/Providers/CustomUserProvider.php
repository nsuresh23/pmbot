<?php

namespace App\Providers;

use Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class CustomUserProvider implements UserProvider
{

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */

    public function retrieveById($identifier)
    {
        // TODO: Implement retrieveById() method.

        $userData = Session::get('api_user');

        if (count($userData) > 0) {

            $user = new User();
            //          /* Set any  user specific fields returned by the api request*/
            $user->email = $userData["data"]["email"];
            $user->empcode = $userData["data"]["empcode"];
            $user->role = $userData["data"]["role"];

            return $user;
        }
        return null;
    }

    /**
     * Retrieve a user by by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
        $userData = Session::get('api_user');

        if (count($userData) > 0) {

            $user = new User();
            //          /* Set any  user specific fields returned by the api request*/
            $user->email = $userData["data"]["email"];
            $user->empcode = $userData["data"]["empcode"];
            $user->role = $userData["data"]["role"];

            return $user;
        }
        return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.

        $userData = Session::get('api_user');

        if (count($userData) > 0) {

            $user = new User();
            //          /* Set any  user specific fields returned by the api request*/
            $user->email = $userData["data"]["email"];
            $user->empcode = $userData["data"]["empcode"];
            $user->role = $userData["data"]["role"];

            // $user->setRememberToken($token);

            // $user->save();
        }
        
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        // TODO: Implement retrieveByCredentials() method.
        $userData = Session::get('api_user');

        if (count($userData) > 0) {

            $user = new User();
            //          /* Set any  user specific fields returned by the api request*/
            $user->email = $userData["data"]["email"];
            $user->empcode = $userData["data"]["empcode"];
            $user->role = $userData["data"]["role"];

            return $user;
        }
        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: Implement validateCredentials() method.
        // we'll assume if a user was retrieved, it's good

        // if ($user->Username == $credentials['Username'] && $user->getAuthPassword() == md5($credentials['Password'] . \Config::get('constants.SALT'))) {

        //     $user->last_login_time = Carbon::now();
        //     $user->save();

        //     return true;
        // }
        // return false;

        return true;

    }
}
