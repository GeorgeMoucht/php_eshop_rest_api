<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PHPUnit\Event\TestRunner\ExecutionAborted;
use Symfony\Component\ErrorHandler\Error\UndefinedMethodError;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
     * Accept $request (HTTP request),
     * and $e which represents an instance of Exception or Throwable.
     * This is a type of union, so the function can accept
     * an instance of any class that implements the Exception or Throwable
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, \Exception|Throwable $e)
    {
        // Determine if the response should be in JSON format.
        if ($request->wantsJson() || $request->ajax()){

            // Init array named $response with an error message.
            $response = [
                'error' => __('Sorry, something went wrong.')
            ];

            // Generate Default response
            $response = $this->generateDefaultResponse($e, $response);

            // Init response status
            $status = 400;

            // Check if the thrown exception is instance of HTTP.
            if ($this->isHttpException($e)){
                $status = $e->getStatusCode();
            }

            // If we have httpException
            if ($e instanceof HttpException){
                return response()->json($this->responseData($response, 403), $status);
            }

            if ($e instanceof UndefinedMethodError){
                return response()->json($this->responseData($response), $status);
            }

            // Fallback response.
            return response()->json($response, $status);
        }
        // If request is not JSON or AJAX then run default Laravel exception.
        return parent::render($request, $e);
    }

    /**
     * @param Throwable|\Exception $e
     * @param array $response
     * @return array
     */
    private function generateDefaultResponse(Throwable|\Exception $e, array $response): array
    {
        if (config('app.debug')) {
            $response['exception'] = get_class($e);
            $response['status'] = $e->getCode();
            $response['line'] = $e->getLine();
            $response['file'] = $e->getFile();
            $response['message'] = $e->getMessage();
            $response['trace'] = $e->getTrace();
        }
        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    public function responseData(array $response, $status = 400): array
    {
        $response = [
            'error'   => true,
            'message' => $response['message'],
            'status'  => $status,
        ];
        return $response;
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(
            [
                'errors' => [
                    'status' => 401,
                    'message' => 'You need to be authenticated user.',
                ]
            ], 401
        );
    }
}
