<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable, DataResponse, ResponseCode;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
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
        try {
            $statusCode = ResponseCode::SERVICE_ERROR;
            if(method_exists($exception, 'getStatusCode')){
                $statusCode = $exception->getStatusCode();
            }
            if ($request->ajax() || $request->wantsJson()) {
                $response = new DataResponse();
                $response->SetException($exception);
                $response->code = $statusCode;
                if($statusCode == ResponseCode::UNAUTHORIZED
                    || $statusCode == ResponseCode::FORBIDDEN
                    || $statusCode == ResponseCode::NOT_FOUND) {
                    $response->msgNo = 'E'.$statusCode;
                }
                return response($response->GetData());
            }
            else {
                return response()->view('Admin::Error.' . $statusCode, [], 200);
            }
        }
        catch(\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                $response = new DataResponse();
                $response->SetException($e);
                return response($response->GetData());
            }
            else {
                return response()->view('Admin::Error.500', ['error' => $e->getMessage()], 200);
            }
        }
        return parent::render($request, $exception);
    }
}
