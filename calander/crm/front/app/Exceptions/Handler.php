<?php

namespace App\Exceptions;

use Exception;
/*use Illuminate\Validation\ValidationException;*/
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Exceptions\NotAuthorizedException;
use Optimait\Laravel\Exceptions\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        /*ValidationException::class,*/
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        
         error_reporting(0);
        if ($e instanceof ValidationException){
            if(\Request::ajax()){
                return response()->json(array(
                    'notification'=>ReturnValidationNotification($e->getErrors())
                ));
            }
            return back()->withInput()->withErrors($e->getErrors());
        }


        if ($e instanceof ApplicationException){
            if(\Request::ajax()){
                return response()->json(array(
                    'notification'=>ReturnNotification(array('info' => $e->getMessage()))
                ));
            }
            return back()->withInput()->with('info', $e->getMessage());
        }

        /*for not authorized */
        if($e instanceof NotAuthorizedException){
            if(\Request::ajax()){
                return response()->json(array(
                    'notification'=>ReturnNotification(array('error' => 'Not Authorized'))
                ));
            }
            return redirect('webpanel/unauthorized');
        }


        return parent::render($request, $e);
    }
}
