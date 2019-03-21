<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            $this->convertExceptionToResponse($exception, $request);
        } else if($exception instanceof ModelNotFoundException) {
            $model = class_basename($exception->getModel());
            return $this->errorResponse("There is no {$model} instance with the specified id.", 404);
        } else if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request,$exception);
        } else if($exception instanceof AuthorizationException) {
            return $this->errorResponse('You do not have permissions to execute this action.', 403);
        } else if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified url was not found.', 404);
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('Method not allowed.', 405);
        } else if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        } else if ($exception instanceof QueryException) {
            $code = $exception->errorInfo[1];
            if ($code == 1451) {
                return $this->errorResponse('You can not permanently delete the resource because it is related to someone else.', 409);
            }
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Unexpected failure. Try again later', 500);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('Unauthenticated.', 401);
    }
}
