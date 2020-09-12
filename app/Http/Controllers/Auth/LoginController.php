<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Traits\General\CustomLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Resources\User\UserCollection as UserResource;
use Exception;

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

    use CustomLogger;

    protected $userResource = "";

    protected $error_message = "";

    // protected $maxAttempts = 1; // Default is 5
    // protected $decayMinutes = 1; // Default is 1

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';//home
    // protected $redirectTo = 'dashboard';//home
    protected $redirectTo = 'home';//home


    // public function redirectTo()
    // {

    //     // User role
    //     $role = Auth::user()->roles->name;

    //     // Check user role
    //     switch ($role) {

    //         case 'am':
    //             // return redirect()->route('dashboard');
    //             // return '/dashboard';
    //             return '/am/dashboard';
    //             break;
    //         case 'admin':
    //             return '/pm/dashboard';
    //             break;
    //         case 'pm':
    //             return '/pm/dashboard';
    //             break;
    //         case 'stakeholder':
    //             return '/stakeholders/dashboard';
    //             break;
    //         default:
    //             return '/login';
    //             break;
    //     }
    // }



   /* protected function authenticated(Request $request, $user)
    {
        if ( $user->isAdmin() ) {// do your margic here
            return redirect()->route('home');
        }

     return redirect('/home');
    }
*/
     public function username()
    {
       $login = request()->input('email_or_username');
       $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
       request()->merge([$field => $login]);
       return $field;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userResource = new UserResource();
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {

        try {

            if (isset($request->email_or_username) && $request->email_or_username != "" && isset($request->password) && $request->password != "") {

                $param = [
                    "empcode" => $request->email_or_username,
                    // "password" => md5($request->password),
                    // "password" => $request->password,
                    // "password" => bcrypt($request->password),
                    "password" => md5($request->password),
                    "ldap_password" => base64_encode($request->ldap_password),
                    "ipaddress" => request()->ip(),
                ];

                $responseData = $this->userResource->login($param);

                // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($param);echo '<PRE/>';
                // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($responseData);echo '<PRE/>';exit;

                // $responseData["data"] = [
                //     "email" => $request->email_or_username,
                //     "username" => "admin",
                //     "empcode" => "205410",
                //     "role" => "admin"
                // ];

                // $responseData["data"] = [
                //     "email" => $request->email_or_username,
                //     "username" => $request->email_or_username,
                //     "empcode" => $request->email_or_username,
                //     "role" => "admin",
                //     "status" => "1"
                // ];

                // $responseData["success"] = "true";

                if(isset($responseData["success"]) && $responseData["success"] == "true" && $responseData["data"] != "") {

                    if(isset($responseData["data"]["status"]) && $responseData["data"]["status"] == "1") {

                        $this->info("app_data_".date('Y-m-d'), json_encode($request->all()));

                        // $conditions = [
                            //     ['email', $responseData["data"]["email"]],
                            // ];

                            $conditions = [
                                ['empcode', $responseData["data"]["empcode"]],
                            ];

                            // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($conditions);echo '<PRE/>';exit;

                            $fields = ['id'];

                            $userData = [];

                            $userData = $this->userResource->getUserField($conditions, $fields);


                        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($request->all());echo '<PRE/>';exit;

                        if(isset($userData->id) && $userData->id != "") {

                            $rememberMe = false;

                            if(isset($request->remember) && $request->remember == "on") {

                                $rememberMe = true;

                            }

                            // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($userData);echo '<PRE/>';exit;
                            Auth::loginUsingId($userData->id, $rememberMe);

                            // $this->login($request);
                        }

                    }

                } else {

                    $this->error_message = "";

                    $this->error_message = $responseData["message"];

                    $this->sendFailedLoginResponse($request);

                }

                return false;
            }

        } catch(Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

        }

    }

    protected function sendFailedLoginResponse($request)
    {

        // throw ValidationException::withMessages([
        //     "error_message" => [$this->error_message],
        // ]);

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($this->error_message);echo '<PRE/>';exit;

        $errors = new MessageBag(['error_message' => [$this->error_message]]);

        return redirect()->route('login')->withErrors($errors)->withInput([$request->except('password', 'ldap_password')]);
    }

}
