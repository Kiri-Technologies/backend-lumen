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
     * Get all User.
     *
     * @return Response
     */
    // public function allUsers()
    // {
    //      return response()->json(['users' =>  User::all()], 200);
    // }

    /**
     * Get one user.
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
     * Get one user.
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
        ], 201);
    }
}
