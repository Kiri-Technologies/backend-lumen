<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Routes;
use App\Models\Setpoints;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\FeedbackApplication;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Laravel\Lumen\Routing\Controller;


use App\Models\Vehicle;
use App\Models\Trip;
use App\Models\History;

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

    //  ===============================================================================
    //  ====================================== USER ===================================
    //  ===============================================================================


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
                'phone_number' => 'required',
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
            $user->phone_number = $request->input('phone_number');

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
    public function findUser(Request $request)
    {
        $user = User::when($request->role, function ($query, $role) {
            return $query->where('role', $role);
        })->when($request->id, function ($query, $id) {
            return $query->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'message' => 'User Requested !',
            'data' => $user,
        ], 200);
    }

    //  ===============================================================================
    //  ==================================== ANGKOT ===================================
    //  ===============================================================================

    /**
     * Get all vehicle.
     *
     * @return Response
     */
    public function allAngkot()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Angkot Requested !',
            'data' => Vehicle::with('user_owner', 'route')->get(),
        ], 200);
    }


    /**
     * Update status on vehicle
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
                $vehicle = Vehicle::find($id);
                $vehicle->status = $request->input('status');
                $vehicle->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Approval Status Updated !',
                    'data' => $vehicle,
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
     * Delete vehicle by id
     *
     * @return Response
     */
    public function DeleteAngkotById(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::find($id);
            $vehicle->delete();

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

    //  ===============================================================================
    //  ====================================== TRIP ===================================
    //  ===============================================================================


    /**
     * Get All Trip.
     *
     * @return Response
     *
     */
    public function getAllPerjalanan()
    {
        $trip = Trip::with('user_penumpang', 'vehicle.route', 'user_supir', 'feedback')->get();

        if (!$trip) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Trip Not Found!',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Trip Requested !',
            'data' => $trip,
        ], 200);
    }

    //  ===============================================================================
    //  ===================================== RIWAYAT =================================
    //  ===============================================================================

    /**
     * get history supir narik by id
     *
     * @param int $id
     * @return Response
     */
    public function allRiwayat()
    {
        $history =  History::with('supir')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'get all history successfully!',
            'data' => $history
        ], 200);
    }

    //  ===============================================================================
    //  ================================= ROUTES ======================================
    //  ===============================================================================

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
            'kode_trayek' => 'required',
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
                $routes->kode_trayek = $request->input('kode_trayek');
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
            'kode_trayek' => 'required',
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
                $routes->kode_trayek = $request->input('kode_trayek');
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
     * Delete a Routes
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

    //  ===============================================================================
    //  =============================== FEEDBACK APP ==================================
    //  ===============================================================================

    /**
     * Updatee Feedback App
     *
     *
     * @return Response
     */
    public function updateAppFeedback(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required |in:submitted,pending,processed,cancelled',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        } else {
            try {
                $feedbackapp = FeedbackApplication::with('user')->find($id);
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
    public function getAllAppFeedback()
    {
        // sort by newest feedback
        $feedbackapp = FeedbackApplication::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Feedback Requested !',
            'data' => $feedbackapp,
        ], 200);
    }

    /**
     * Get Application Feedback find by status
     *
     * @return Response
     */
    public function getAppFeedbackFind(Request $request)
    {
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
            $feedbackapp = FeedbackApplication::with('user')->where('status', $request->input('status'))->get();
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

    //  ===============================================================================
    //  =============================== Halte Virtual =================================
    //  ===============================================================================

    /**
     * create Halte Virtual App
     *
     * @return Response
     */
    public function createHalteVirtual(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required',
            'nama_lokasi' => "required",
            'lat' => "required",
            'long' => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->error(),
                'data' => []
            ], 400);
        } else {
            try {
                $point = new Setpoints();
                $point->route_id = $request->input("route_id");
                $point->nama_lokasi = $request->input("nama_lokasi");
                $point->lat = $request->input("lat");
                $point->long = $request->input("long");
                $point->save();

                return response()->json([
                    'status' => 'success',
                    "message" => 'Halte Virtual Created',
                    'data' => $point,
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
     * Get Halte Virtual By Id App
     *
     * @return Response
     */
    public function getByIdHalteVirtual($id)
    {
        try {
            $point = Setpoints::find($id);

            if ($point == null) {
                return response()->json([
                    'status' => 'Not Found',
                    'message' => 'Halte Virtual Not Found',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Halte Virtual Requested !',
                'data' => $point,
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
     * Get Halte Virtual By route_id App
     *
     * @return Response
     */
    public function getByRouteIdHalteVirtual()
    {
        try {
            $route = request(["route_id"]);
            $point = Setpoints::where('route_id', $route)->get();

            if ($point == null) {
                return response()->json([
                    'status' => 'Not Found',
                    'message' => 'Halte Virtual Not Found',
                    'data' => [],
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Halte Virtual Requested !',
                'data' => $point,
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
     * Update Halte Virtual App
     *
     * @return Response
     */
    public function updateHalteVirtual(Request $request, $id)
    {
        try {
            $setpoints = Setpoints::find($id);
            $setpoints->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Halte Virtual Updated !',
                'data' => $setpoints,
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
     * Delete Halte Virtual App
     *
     * @return Response
     */
    public function deleteHalteVirtual($id)
    {
        try {
            $point = Setpoints::find($id);

            if ($point) {
                $point->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Halte Virtual Deleted !',
                    'data' => [],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Halte Virtual Not Found!',
                    'data' => [],
                ], 400);
            }
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
     * Get Graphic total pendapatan this month
     *
     * @return Response
     */
    public function totalPendapatanBulanIni()
    {
        $pendapatan = History::whereMonth('created_at', Carbon::now()->month)->sum('jumlah_pendapatan');
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => [
                'total_pendapatan_bulan_ini' => $pendapatan
            ],
        ], 200);
    }

    /**
     * Get Graphic total angkot register this month
     *
     * @return Response
     */
    public function totalAngkotMendaftarBulanIni()
    {
        $angkot = Vehicle::whereMonth('created_at', Carbon::now()->month)->count();
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => [
                'total_angkot_terdaftar_bulan_ini' => $angkot
            ],
        ], 200);
    }

    /**
     * Get Graphic total registered angkot all time
     *
     * @return Response
     */
    public function totalAngkotTerdaftar()
    {
        $angkot = Vehicle::count();
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => [
                'total_angkot_terdaftar' => $angkot
            ],
        ], 200);
    }

    /**
     * Get Graphic total pendapatan previous month
     *
     * @return Response
     */
    public function totalPendapatanBulanLalu()
    {
        $pendapatan = History::whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('jumlah_pendapatan');
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => [
                'total_pendapatan_bulan_ini' => $pendapatan
            ],
        ], 200);
    }

    /**
     * Get Total User App
     *
     * @return Response
     */
    public function getTotalUsers()
    {
        $owner = User::where('role', 'owner')->count();
        $penumpang = User::where('role', 'penumpang')->count();
        $supir = User::where('role', 'supir')->count();

        $total_user = [
            'owner' => $owner,
            'penumpang' => $penumpang,
            'supir' => $supir
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Total User',
            'data' => $total_user,
        ], 200);
    }
}
