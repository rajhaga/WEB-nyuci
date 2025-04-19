<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
use Illuminate\Database\ConnectionException;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Handle 404 error (Page Not Found)
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        // Handle 500 error (Server Error) - Database query issue
        if ($exception instanceof QueryException) {
            return response()->view('errors.500', [], 500);
        }

        // Handle Connection Exception (offline or database connection error)
        if ($exception instanceof ConnectionException) {
            return response()->view('errors.offline', [], 503); // Service Unavailable (503)
        }

        // Handle other exceptions (you can add more custom exception types)
        return parent::render($request, $exception);
    }

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log or handle other exceptions here
        });
    }
}

