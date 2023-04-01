<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Library\JsonResponseData;
use App\Library\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth;

class ApiAuthController extends Controller
{
    public function postRegister(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } catch (\Exception $exception) {
            return response()->json(JsonResponseData::formatData(
                $request,
                'Failed Creating New User',
                Message::MESSAGE_ERROR,
            ), 409);
        }


        $token = auth('api')->login($user);

        return $this->respondWithToken(
            $request,
            $token,
            'Thank you for registering',
            Message::MESSAGE_SUCCESS,
            $user,
        );
    }

    public function postLogin(Request $request): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(JsonResponseData::formatData(
                $request,
                'User/password not found, please try again',
                Message::MESSAGE_ERROR,
                [],
            ), 401);
        }

        $user = User::where('email', $request->input('email'))->first();

        return $this->respondWithToken($request, $token, 'Successfully Logged In', Message::MESSAGE_SUCCESS, $user);
    }

    public function postLogout(Request $request): JsonResponse
    {
        auth('api')->logout();

        return response()->json(JsonResponseData::formatData(
            $request,
            'Successfully logged out',
            Message::MESSAGE_SUCCESS,
            [],
        ));
    }

    public function postRefresh(Request $request): JsonResponse
    {
        return $this->respondWithToken($request, auth('api')->refresh());
    }

    public function getPleaseLogIn(Request $request): JsonResponse
    {
        return response()->json(JsonResponseData::formatData(
            $request,
            'You Must Be Logged In to View this Page',
            Message::MESSAGE_ERROR,
            [],
        ), 401);
    }

    protected function respondWithToken(Request $request, $token, $message = 'Success', $message_type = Message::MESSAGE_OK, $user = null): JsonResponse
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
        ];

        if ($user) {
            $data['user'] = $user;
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            $message,
            $message_type,
            $data,
        ));
    }
}
