<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;


use App\Models\Angkot;
use App\Models\Favorites;
use App\Models\FeedbackApp;
use App\Models\FeedbackApplication;
use App\Models\ListSupir;
use App\Models\Perjalanan;
use App\Models\Riwayat;
use App\Models\Routes;
use App\Models\Setpoints;
use App\Models\User;

class AdminController  extends Controller
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
            'message' => 'Angkot Requested !',
            'data' => Angkot::with('user_owner','route')->get(),
        ], 200);
    }

    /**
     * Get list supir
     *
     * @return Response
     */
    public function getListSupir()
    {
        $list_supir = ListSupir::all();
        if ($list_supir) {
            return response()->json([
                'status' => 'success',
                'message' => 'List Supir Requested !',
                'data' => $list_supir,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'List Supir Not Found!',
                'data' => [],
            ], 400);
        }
    }


    /**
     * Update status on angkot
     *
     * @return Response
     */
    public function updateStatusApproval(Request $request, $id)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,pending,decline',
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
                $angkot = Angkot::find($id);
                $angkot->status = $request->input('status');
                $angkot->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Approval Status Updated !',
                    'data' => $angkot,
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
     * Delete angkot by id
     *
     * @return Response
     */
    public function DeleteAngkotById(Request $request, $id)
    {
        try {
            $angkot = Angkot::find($id);
            $angkot->delete();

            //return successful response
            return response()->json([
                'status' => 'success',
                'message' => 'Angkot Deleted !',
                'data' => [],
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


    /**
     * Get All Perjalanan.
     *
     * @return Response
     *
     */
    public function getAllPerjalanan()
    {
        $perjalanan = Perjalanan::with('user_penumpang','angkot','user_supir')->get();
        $routes = new Collection(Routes::all());
        foreach($perjalanan as $pj){
            $pj->{"routes"} = $routes->where('id', $pj->angkot->route_id)->first();
        }


        if (!$perjalanan) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Perjalanan Not Found!',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Perjalanan Requested !',
            'data' => $perjalanan,
        ], 200);
    }

    /**
     * Get All Routes.
     *
     * @return Response
     *
     */
    public function getAllRoutes()
    {
        $route = Routes::all();
        if (!$route) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Routes Not Found!',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Routes Requested !',
            'data' => $route,
        ], 200);
    }

    /**
     * Create a routes.
     *
     * @param  int  $id
     * @return Response
     */
    public function createRoutes(Request $request)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'kode_angkot' => 'required',
            'titik_awal' => 'required',
            'titik_akhir' => 'required',
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
                $routes = new Routes;
                $routes->kode_angkot = $request->input('kode_angkot');
                $routes->titik_awal = $request->input('titik_awal');
                $routes->titik_akhir = $request->input('titik_akhir');
                $routes->save();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Route Created !',
                    'data' => $routes,
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
     * Update a Routes
     *
     * @param  int  $id
     * @return Response
     */
    public function updateRoutes(Request $request, $id)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'kode_angkot' => 'required',
            'titik_awal' => 'required',
            'titik_akhir' => 'required',
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
                $routes = Routes::find($id);
                $routes->kode_angkot = $request->input('kode_angkot');
                $routes->titik_awal = $request->input('titik_awal');
                $routes->titik_akhir = $request->input('titik_akhir');
                $routes->save();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Route Updated !',
                    'data' => $routes,
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
     * get riwayat supir narik by id
     *
     * @param int $id
     * @return Response
     */
    public function allRiwayat()
    {
        $riwayat =  Riwayat::with('supir')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'get all riwayat successfully!',
            'data' => $riwayat
        ], 200);
    }



    /**
     * Update a Routes
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteRoutes(Request $request, $id)
    {
        try {
            $routes = Routes::find($id);
            $routes->delete();

            // return successful response
            return response()->json([
                'status' => 'success',
                'message' => 'Route Deleted !',
                'data' => $routes,
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

    /**
     * Updatee Feedback App
     *
     *
     * @return Response
     */
    public function updateAppFeedback(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'status' => 'required |in:submitted,pending,processed',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        } else {
            try {
                $feedbackapp = FeedbackApplication::find($id);
                $feedbackapp->status = $request->input('status');
                $feedbackapp->save();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Feedback Updated !',
                    'data' => $feedbackapp,
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
     * Get All Application Feedback
     *
     * @return Response
     */
    public function getAllAppFeedback() {
        $feedbackapp = FeedbackApplication::all();
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $feedbackapp
        ], 200);
    }

    /**
     * Get Application Feedback find by status
     *
     * @return Response
     */
    public function getAppFeedbackFind(Request $request) {
        $validator = Validator::make($request->all(), [
            'status' => 'required |in:submitted,pending,processed',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        } else {
            $feedbackapp = FeedbackApplication::where('status', $request->input('status'))->get();
            // check if feedbackapp is not empty
            if (count($feedbackapp) > 0) {
                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'ok',
                    'data' => $feedbackapp,
                ], 200);
            } else {
                // return error message
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Feedback Application not found !',
                    'data' => [],
                ], 404);
            }
        }

    }

}
