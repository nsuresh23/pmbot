<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Exception;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use App\Traits\General\CustomLogger;
use App\Resources\User\UserCollection as UserResource;


class SessionExpired
{
    protected $session;

    use CustomLogger;

    protected $timeout = 120;

    protected $userResource = "";

    public function __construct(Store $session)
    {
        $this->session = $session;

        $this->timeout = env('SESSION_TIMEOUT_LIFETIME', 30);

        $this->userResource = new UserResource();

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $isLoggedIn = $request->path() != 'logout';

        if (!session('lastActivityTime')) {

            $this->session->put('lastActivityTime', time());

        } elseif (time() - $this->session->get('lastActivityTime') > (int)$this->timeout * 60) {


            $this->session->forget('lastActivityTime');

            // $cookie = cookie('intend', $isLoggedIn ? url()->current() : 'home');

            try {

                if (auth()->check()) {

                    $loginHistoryField = [];

                    $loginHistoryField["empcode"] = auth()->user()->empcode;
                    $loginHistoryField["creator_empcode"] = "";

                    if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                        $loginHistoryField["creator_empcode"] = session()->get("current_empcode");

                    }

                    $loginHistoryField["type"] = "valid";
                    $loginHistoryField["action_type"] = "logout";
                    $loginHistoryField["ipaddress"] = request()->ip();

                    $this->info("app_data_" . date('Y-m-d'), json_encode("logout params"));
                    $this->info("app_data_" . date('Y-m-d'), json_encode($loginHistoryField));

                    $this->userResource->loginHistory($loginHistoryField);

                    Auth::logout();

                    return redirect("login");

                }

            } catch (Exception $e) {

                $this->error(
                    "app_error_log_" . date('Y-m-d'),
                    " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                        " => MESSAGE => " . $e->getMessage() . " "
                );
            }

        }

        $isLoggedIn ? $this->session->put('lastActivityTime', time()) : $this->session->forget('lastActivityTime');

        return $next($request);

    }
}
