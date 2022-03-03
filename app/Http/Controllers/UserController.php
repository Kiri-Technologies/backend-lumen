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

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User Profile Requested !',
            'data' => Auth::user(),
        ], 200);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    // public function allUsers()
    // {
    //      return response()->json(['users' =>  User::all()], 200);
    // }

    /**
     * Update one user.
     *
     * @return Response
     */
    public function updateUser(Request $request)
    {
        $user = Auth::user();

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
        } else {
            try {
                $user = User::find(Auth::user()->id);
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
     * Logout.
     *
     * @return Response
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'User Logout!',
            'data' => [],
        ], 200);
    }

    /**
     * Get Angkot By ID.
     *
     * @return Response
     */
    public function getAngkotByID($id) {
        $angkot = Angkot::find($id);
        if (!$angkot) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Angkot Not Found!',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Angkot Requested !',
            'data' => [$angkot],
        ], 200);
    }

    /**
     * Get Angkot Sorting.
     * Sort by owner_id
     *
     * @return Response
     */
    public function getAngkotSorting() {
        $angkot = Angkot::orderBy('id', 'asc')->get();
        if (!$angkot) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Angkot Not Found!',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Angkot Sorting Requested !',
            'data' => [$angkot],
        ], 200);
    }
}
