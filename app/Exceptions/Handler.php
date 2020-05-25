<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //check if exception is an instance of ModelNotFoundException.
        //or NotFoundHttpException
        if ($exception instanceof ModelNotFoundException or $exception instanceof NotFoundHttpException) {

            // ajax 404 json feedback
            if ($request->ajax()) {
                return response()->json(['error' => 'Not Found'], 404);
            }

            // normal 404 view page feedback
            return response()->view('errors.error404', [], 404);
        }

        // Handle the exception...
        // redirect back with form input except the _token (forcing a new token to be generated)
        if ($exception instanceof TokenMismatchException) {

            // return redirect()->back()->withInput($request->except('_token'))->withFlashDanger('You page session expired. Please try again');
            return response()->view('auth.login');
        }

        // Handle the exception...
        // redirect back with form input except the _token (forcing a new token to be generated)
        if ($exception instanceof MethodNotAllowedHttpException) {

            // return redirect()->back()->withInput($request->except('_token'))->withFlashDanger('You page session expired. Please try again');
            return response()->view('auth.login');
        }

        // Handle the exception...
        // redirect back with form input except the _token (forcing a new token to be generated)
        if ($exception instanceof NotFoundHttpException) {

            /// normal 404 view page feedback
            return response()->view('errors.error404', [], 404);
        }

        // Handle the exception...
        // redirect back with form input except the _token (forcing a new token to be generated)
        if ($exception instanceof ConnectException) {

            // return redirect()->back()->withInput($request->except('_token'))->withFlashDanger('You page session expired. Please try again');
            return response()->view('errors.errorTryAgain');
        }


        // if ($this->isHttpException($exception)) {
        //     switch ($exception->getStatusCode()) {

        //             // not authorized
        //         case '403':
        //             return response()->view('errors.403', array(), 403);
        //             break;

        //             // not found
        //         case '404':
        //             return response()->view('errors.404', array(), 404);
        //             break;

        //             // internal error
        //         case '500':
        //             return \response()->view('errors.500', array(), 500);
        //             break;

        //         default:
        //             return $this->renderHttpException($exception);
        //             break;
        //     }
        // } else {
        //     return parent::render($request, $exception);
        // }

        return parent::render($request, $exception);
    }
}
