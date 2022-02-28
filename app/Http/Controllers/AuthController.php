<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Validator;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'birthdate' => 'required|date',
            'role' => 'required|in:admin,penumpang,owner,supir',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            //return failed response
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        } else {
            try {
                $user = new User;
                $user->id = Str::slug($request->input('name')) . "-" . Str::random(6);
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->password = app('hash')->make($request->input('password'));
                $user->birthdate = $request->input('birthdate');
                $user->role = $request->input('role');
                $user->no_hp = $request->input('no_hp');

                $user->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Created !',
                    'data' => $user,
                ], 201);
            } catch (\Exception $e) {
                //return error message
                return response()->json([
                    'status' => 'failed',
                    'message' => $e,
                    'data' => [],
                ], 409);
            }
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return failed response
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized',
                'data' => [],
            ], 401);
        }

        $user = User::where('email', '=', $request->input('email'))->first();
        $user->{"token"} = $this->respondWithToken($token);

        return response()->json([
            'status' => 'success',
            'message' => 'User Logged In !',
            'data' => $user,
        ], 200);
    }
}
