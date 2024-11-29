<?php

use Illuminate\Http\Response;
use App\Http\Middleware\Sanitizer;
use App\Http\Responses\ResponseError;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AppExceptionHandler
{
    public function renderExceptions($exceptions)
    {
        $exceptions->render(function (\Exception $e, $request) {
            // Define a mapping of exceptions to their corresponding HTTP status codes
            $exceptionMapping = [
                AuthenticationException::class   => Response::HTTP_UNAUTHORIZED,
                ThrottleRequestsException::class => Response::HTTP_TOO_MANY_REQUESTS,
                AccessDeniedHttpException::class => Response::HTTP_UNAUTHORIZED,
                ModelNotFoundException::class    => Response::HTTP_NOT_FOUND,
                NotFoundHttpException::class     => Response::HTTP_NOT_FOUND,
                HttpException::class             => Response::HTTP_FORBIDDEN,
            ];

            // Get the exception class name
            $exceptionClass = get_class($e);

            // Get the exception message
            $message = $e->getMessage();

            if ($e instanceof HttpException) {
                $message = 'Action Prohibited';
            }

            if (
                $e instanceof ModelNotFoundException ||
                $e instanceof NotFoundHttpException ||
                $e instanceof ThrottleRequestsException
            ) {
                $message = $e->getMessage();
            }

            // Check if the exception class is in the mapping
            if (array_key_exists($exceptionClass, $exceptionMapping)) {
                // Get the corresponding status code
                $statusCode = $exceptionMapping[$exceptionClass];

                if ($request->expectsJson()) {
                    // Return the custom response
                    return new ResponseError(
                        message: $message,
                        status_code: $statusCode
                    );
                }

                // Return a web response (HTML) for non-API requests
                return redirect()->route('login.insight');
            }
        });
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            Sanitizer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        (new AppExceptionHandler)->renderExceptions($exceptions);
    })->create();
