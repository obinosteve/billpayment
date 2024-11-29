<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UsersResource;
use App\Http\Responses\ResponseError;
use App\Http\Responses\ResponseSuccess;
use App\Http\Requests\RegistrationRequest;
use App\Actions\Authentication\LoginAction;
use App\Actions\Authentication\LogoutAction;
use App\Actions\Authentication\RegisterAction;

class AuthenticationController
{

    /**
     * Log out user
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request): ResponseSuccess|ResponseError
    {
        try {
            $user = RegisterAction::execute($request->all());
        } catch (Exception $e) {
            return new ResponseError(getExceptionMessage($e), getExceptionCode($e));
        }

        return new ResponseSuccess(
            message: 'Registration successful',
            status_code: Response::HTTP_CREATED,
            response: [
                'data' => new UsersResource($user)
            ]
        );
    }

    /**
     * Log in user
     *
     * @param App\Http\Requests\LoginRequest $request
     *
     * @return App\Http\Responses\ResponseSuccess
     * @return App\Http\Responses\ResponseError
     */
    public function login(LoginRequest $request): ResponseSuccess|ResponseError
    {
        try {
            $token = LoginAction::execute($request->all());
        } catch (Exception $e) {
            return new ResponseError(getExceptionMessage($e), getExceptionCode($e));
        }

        return new ResponseSuccess(
            message: 'Login successful',
            response: [
                'data' =>  [
                    'token' => $token,
                ]
            ]
        );
    }

    /**
     * Log out user
     *
     * @return JsonResponse
     */
    public function logout(): ResponseSuccess|ResponseError
    {
        try {
            LogoutAction::execute();
        } catch (Exception $e) {
            return new ResponseError(getExceptionMessage($e), getExceptionCode($e));
        }

        return new ResponseSuccess(
            message: 'Logout successful!',
            status_code: Response::HTTP_OK
        );
    }
}
