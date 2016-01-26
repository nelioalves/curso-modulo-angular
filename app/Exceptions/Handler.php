<?php

namespace CodeProject\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidationException;
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
        ValidationException::class,
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
        /**
         * Output error response depending on the exception fired
         */
        $className = get_class($e);
        switch (true) {
            case (strpos($className,'League\OAuth2\Server\Exception') !== false):
                // Return JSON response
                return $this->JSONHandler($e);
            case (strpos($className,'LucaDegasperi\OAuth2Server\Exceptions') !== false):
                // Return JSON response
                return $this->JSONHandler($e);
            default:
                // Any other response
                return parent::render($request, $e);
            break;
        }

    }

    /**
     * Return exception as JSON response with status code.
     *
     * @param  \Exception  $e
     * @return mixed
     */
    private function JSONHandler(Exception $e) {
        $data = [
            'error' => $e->errorType,
            'error_description' => $e->getMessage(),
        ];
        return new \Illuminate\Http\JsonResponse($data, $e->httpStatusCode, $e->getHttpHeaders());
    }


/*    
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }
*/
}
