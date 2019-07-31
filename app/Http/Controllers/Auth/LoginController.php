<?php

namespace PMBot\Http\Controllers\Auth;

use PMBot\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // /**
    //  * We're doing LDAP Auth in this application
    //  * so use the ldap username instead of email address to login
    //  * This property corresponds with ‘ldap_username’ column in the user table
    //  */
    // public function username()
    // {
    //     return 'ldap_username';
    // }

    // protected function credentials(Request $request)
    // {
    //     return [
    //         'email' => $request->{$this->username()},
    //         'password' => $request->password,
    //         'is_active' => true
    //     ];
    // }

    // /**
    //  * Get the post register / login redirect path.
    //  *
    //  * @return string
    //  */
    // public function redirectPath()
    // {
    //     if(Auth::user()->type == 'author') {
    //         return '/author-dashboard';
    //     } else if (Auth::user()->type == 'reader') {
    //         return '/reader-dashboard';
    //     } else {
    //         return '/home';
    //     }
    // }

    // /**
    //  * Get the failed login response instance.
    //  *
    //  * @param \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // protected function sendFailedLoginResponse(Request $request)
    // {
    //     return response()->json([
    //         'error' => 'Credentials do not match, try again.'
    //     ], 406);
    // }

}
