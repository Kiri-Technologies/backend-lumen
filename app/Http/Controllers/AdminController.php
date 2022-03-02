<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Angkot;

class AdminController  extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin_auth');
    }


    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'message' => 'User Profile Requested !',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e,
                'data' => [],
            ], 409);
        }
    }


    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All User Requested !',
            'data' => User::all(),
        ], 200);
    }

    /**
     * Delete user.
     *
     * @return Response
     */
    public function updateUser($id, Request $request)
    {
        $user = User::find($id);
        if ($user) {
            // $user->delete();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => ['required', Rule::unique('users', 'email')->ignore($user)],
                'password' => 'required',
                'birthdate' => 'required|date',
                'role' => 'required|in:admin,penumpang,owner,supir',
                'no_hp' => 'required',
                'image' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                //return failed response
                return response()->json([
                    'status' => 'failed',
                    'message' => $validator->errors(),
                    'data' => [],
                ], 400);
            }

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($request->input('password'));
            $user->birthdate = $request->input('birthdate');
            $user->role = $request->input('role');
            $user->no_hp = $request->input('no_hp');

            if (isset($request->image)) {
                // Delete Old Image ( Still Not Working I Guess)
                if (isset($user->image)) {
                    if (File::exists($user->image)) {
                        File::delete($user->image);
                    }
                }
                // Upload Image
                $image = $request->file('image');
                $image_name = Str::random(15) . "." . $image->getClientOriginalExtension();
                $image->move(public_path('/images'), $image_name);
                $user->image = "/images/" . $image_name;
            }

            $user->save();

            //return successful response
            return response()->json([
                'status' => 'success',
                'message' => 'User Updated !',
                'data' => $user,
            ], 201);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Not Found!',
                'data' => [],
            ], 400);
        }
    }

    /**
     * Delete user.
     *
     * @return Response
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User Deleted !',
                'data' => [],
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Not Found!',
                'data' => [],
            ], 400);
        }
    }

    /**
     * Get find user.
     *
     * @return Response
     */
    public function findUser()
    {
        if (isset($_GET['role']) && isset($_GET['id'])) {
            $role = $_GET['role'];
            $id = $_GET['id'];
            $user = User::where("role", "like", '%' . $role . '%')->where("id", "like", '%' . $id . '%')->get();
        } elseif (isset($_GET['role'])) {
            $role = $_GET['role'];
            $user = User::where("role", "like", '%' . $role . '%')->get();
        } elseif (isset($_GET['id'])) {
            $id = $_GET['id'];
            $user = User::where("id", "like", '%' . $id . '%')->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User Requested !',
            'data' => $user,
        ], 200);
    }

    /**
     * Get all angkot.
     *
     * @return Response
     */
    public function allAngkot()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User Requested !',
            'data' => Angkot::all(),
        ], 200);
    }
}
