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
    public function singleUser()
    {
        // try {
        //     $user = User::findOrFail($id);

        //     return response()->json(['user' => $user], 200);
        // } catch (\Exception $e) {

        //     return response()->json(['message' => 'user not found!'], 404);
        // }

        return "lol";
    }
}
