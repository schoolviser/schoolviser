<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @throws \Throwable
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
        /***if($request->expectsJson()){
            return response()->json([
                'message' => $exception->getMessage(),
            ], $this->getStatusCode($exception));
        }**/
        return parent::render($request, $exception);
    }

    public function unauthenticated($request, AuthenticationException $exception)
    {
        // Check if it's an API request
        if ($request->is('api/*')) {
            return response()->json([
                'error' => 'Unauthenticated',
                'message' => 'Please provide a valid API token.'
            ], 401);
        }

        // Fallback to the default behavior (redirect) for non-API routes
        return parent::unauthenticated($request, $exception);
    }
}
