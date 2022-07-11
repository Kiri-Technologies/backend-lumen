<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Routes;
use App\Models\Setpoints;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Laravel\Lumen\Routing\Controller;


use App\Models\Vehicle;
use App\Models\Trip;
use App\Models\History;
use App\Models\FeedbackApplication;
use App\Models\PremiumUser;
use App\Models\Target;

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
            'status' => 'required|in:approved,pending,declined',
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
        $history =  History::with('supir', 'vehicle.route')->get();
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
            'lat_titik_awal' => 'required',
            'long_titik_awal' => 'required',
            'lat_titik_akhir' => 'required',
            'long_titik_akhir' => 'required',
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
                $routes->lat_titik_awal = $request->input('lat_titik_awal');
                $routes->long_titik_awal = $request->input('long_titik_awal');
                $routes->lat_titik_akhir = $request->input('lat_titik_akhir');
                $routes->long_titik_akhir = $request->input('long_titik_akhir');
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
            'lat_titik_awal' => 'required',
            'long_titik_awal' => 'required',
            'lat_titik_akhir' => 'required',
            'long_titik_akhir' => 'required',
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
                $routes->lat_titik_awal = $request->input('lat_titik_awal');
                $routes->long_titik_awal = $request->input('long_titik_awal');
                $routes->lat_titik_akhir = $request->input('lat_titik_akhir');
                $routes->long_titik_akhir = $request->input('long_titik_akhir');
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
            'long' => "required",
            'arah' => "required"
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
                $point->arah = $request->input("arah");
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
     * Update Halte Virtual App
     *
     * @return Response
     */
    public function updateHalteVirtual(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'route_id' => 'required',
            'nama_lokasi' => "required",
            'lat' => "required",
            'long' => "required",
            'arah' => "required"

        ]);
        try {
            $point = Setpoints::find($id);
            $point->route_id = $request->input("route_id");
            $point->nama_lokasi = $request->input("nama_lokasi");
            $point->lat = $request->input("lat");
            $point->long = $request->input("long");
            $point->arah = $request->input("arah");
            $point->save();

            return response()->json([
                'status' => 'success',
                "message" => 'Halte Virtual Updated',
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

    //  ===================================================================================
    //  ======================================= CHART  ====================================
    //  ===================================================================================

    /**
     * Get Graphic total pendapatan this month
     *
     * @return Response
     */
    public function totalPendapatanBulanIni()
    {
        $pendapatan = History::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('jumlah_pendapatan');
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $pendapatan
        ], 200);
    }

    /**
     * Get Graphic total angkot register this month
     *
     * @return Response
     */
    public function totalAngkotMendaftarBulanIni()
    {
        $angkot = Vehicle::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $angkot
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
            'data' => $angkot
        ], 200);
    }

    /**
     * Get Graphic total pendapatan previous month
     *
     * @return Response
     */
    public function totalPendapatanBulanLalu()
    {
        $date = Carbon::now()->subMonth();
        // $pendapatan = History::whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('jumlah_pendapatan');
        $pendapatan = History::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->sum('jumlah_pendapatan');
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $pendapatan,
        ], 200);
    }

    /**
     * Get Graphic total pendapatan previous month
     *
     * @return Response
     */
    public function totalFeedbackApp()
    {
        $total = FeedbackApplication::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->get();

        $submitted = $total->where('status', 'submitted')->count();
        $pending = $total->where('status', 'pending')->count();
        $processed = $total->where('status', 'processed')->count();
        $cancelled = $total->where('status', 'cancelled')->count();

        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => [
                'submitted' => $submitted,
                'pending' => $pending,
                'processed' => $processed,
                'cancelled' => $cancelled
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

    /**
     * Get Total User App this month and last month
     *
     * @return Response
     */
    public function getTotalUsersThisMonth()
    {
        $thisMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;
        $thisYear = Carbon::now()->year;


        $ownerThisMonth = User::where('role', 'owner')->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->count();
        $penumpangThisMonth = User::where('role', 'penumpang')->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->count();
        $supirThisMonth = User::where('role', 'supir')->whereMonth('created_at', $thisMonth)->whereYear('created_at', $thisYear)->count();

        $ownerLastMonth = User::where('role', 'owner')->whereMonth('created_at', $lastMonth)->whereYear('created_at', $thisYear)->count();
        $penumpangLastMonth = User::where('role', 'penumpang')->whereMonth('created_at', $lastMonth)->whereYear('created_at', $thisYear)->count();
        $supirLastMonth = User::where('role', 'supir')->whereMonth('created_at', $lastMonth)->whereYear('created_at', $thisYear)->count();

        $total_user = [
            'owner' => [
                'this_month' => $ownerThisMonth,
                'last_month' => $ownerLastMonth
            ],
            'penumpang' => [
                'this_month' => $penumpangThisMonth,
                'last_month' => $penumpangLastMonth
            ],
            'supir' => [
                'this_month' => $supirThisMonth,
                'last_month' => $supirLastMonth
            ],
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Total User This Month',
            'data' => $total_user,
        ], 200);
    }

    /**
     * Get Total User App this month and last month
     *
     * @return Response
     */
    public function getTotalUsersLastSixMonth()
    {
        $owner = [];
        $supir = [];
        $penumpang = [];

        for ($month = 0; $month < 6; $month++) {
            $date = Carbon::now()->subMonth($month);

            $ownerCounter = User::where('role', 'owner')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
            $penumpangCounter = User::where('role', 'penumpang')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
            $supirCounter = User::where('role', 'supir')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();

            array_push($owner, $ownerCounter);
            array_push($supir, $supirCounter);
            array_push($penumpang, $penumpangCounter);
        }

        $total_user = [
            'owner' => [
                '1' => $owner[0],
                '2' => $owner[1],
                '3' => $owner[2],
                '4' => $owner[3],
                '5' => $owner[4],
                '6' => $owner[5],
            ],
            'supir' => [
                '1' => $supir[0],
                '2' => $supir[1],
                '3' => $supir[2],
                '4' => $supir[3],
                '5' => $supir[4],
                '6' => $supir[5],
            ],
            'penumpang' => [
                '1' => $penumpang[0],
                '2' => $penumpang[1],
                '3' => $penumpang[2],
                '4' => $penumpang[3],
                '5' => $penumpang[4],
                '6' => $penumpang[5],
            ],
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Total User Last Six Month',
            'data' => $total_user,
        ], 200);
    }

    /**
     * Get Total Premium User This Month
     *
     * @return Response
     */
    public function getTotalPremiumUsersThisMonth()
    {
        $thisDate = Carbon::now();

        $premiumUserThisMonth = PremiumUser::whereDate('to', '>', $thisDate)->count();

        $total_user = [
            'premium_user' => $premiumUserThisMonth
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Total Premium User This Month',
            'data' => $total_user,
        ], 200);
    }

    /**
     * Get Total Premium User Last Six Month
     *
     * @return Response
     */
    public function getTotalPremiumUsersLastSixMonth()
    {
        $premiumUser = [];

        for ($month = 0; $month < 6; $month++) {
            $date = Carbon::now()->subMonth($month);

            if ($month == 0) {
                $premiumUserThisMonth = PremiumUser::whereMonth('to', '>=', $date)->count();
            } else {
                $premiumUserThisMonth = PremiumUser::whereMonth('to', $date->month)->count();
            }

            array_push($premiumUser, $premiumUserThisMonth);
        }

        $total_user = [
            '1' => $premiumUser[0],
            '2' => $premiumUser[1],
            '3' => $premiumUser[2],
            '4' => $premiumUser[3],
            '5' => $premiumUser[4],
            '6' => $premiumUser[5],

        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Total User Last Six Month',
            'data' => $total_user,
        ], 200);
    }

    /**
     * Get Most Used Trayek
     *
     * @return Response
     */
    public function mostUsedTrayek()
    {
        $trayek = Routes::all();
        foreach ($trayek as $tr) {
            $angkot = Vehicle::where('route_id', $tr->id)->get();
            $count = 0;
            foreach ($angkot as $ak) {
                $trip_count = Trip::where('angkot_id', $ak->id)->count();
                $count += $trip_count;
            }
            $tr->count = $count;
        }

        $trayek = $trayek->sortByDesc("count");
        $trayek = $trayek->unique('id')->values();

        return response()->json([
            'status' => 'success',
            'message' => 'Most Used Trayek',
            'data' => $trayek,
        ], 200);
    }

    /**
     * Get Most Used Setpoint
     *
     * @return Response
     */
    public function mostUsedSetpoint()
    {
        $setpoints = Setpoints::all();
        foreach ($setpoints as $st) {
            $trip_count_naik = Trip::where('tempat_naik_id', $st->id)->count();
            $trip_count_turun = Trip::where('tempat_turun_id', $st->id)->count();
            $st->count = $trip_count_naik + $trip_count_turun;
        }

        $setpoints = $setpoints->sortByDesc("count");
        $setpoints = $setpoints->unique('id')->values();

        return response()->json([
            'status' => 'success',
            'message' => 'Most Used Setpoint',
            'data' => $setpoints,
        ], 200);
    }

    /**
     * Graphic Total Perjalanan this month
     * @return Response
     */
    public function totalPerjalananBulanIni()
    {
        $total = Trip::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $total,
        ], 200);
    }

    /**
     * Graphic Total Perjalanan last month
     * @return Response
     */
    public function totalPerjalananBulanLalu()
    {
        $total = Trip::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $total,
        ], 200);
    }

    //  ===================================================================================
    //  ==================================== Premium User  ================================
    //  ===================================================================================

    /**
     * create premium user
     *
     * @return Response
     */
    public function createPremiumUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'payment_date' => "required|date",
            'from' => "required|date",
            'to' => "required|date",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->error(),
                'data' => []
            ], 400);
        }

        $user = User::find($request->input("user_id"));

        if ($user) {
            try {
                $premiumUser = new PremiumUser();
                $premiumUser->user_id = $request->input("user_id");
                $premiumUser->payment_date = $request->input("payment_date");
                $premiumUser->from = $request->input("from");
                $premiumUser->to = $request->input("to");
                $premiumUser->save();

                return response()->json([
                    'status' => 'success',
                    "message" => 'Premium User Created',
                    'data' => $premiumUser,
                ], 201);
            } catch (\Exception $e) {
                //return error message
                return response()->json([
                    'status' => 'failed',
                    'message' => $e,
                    'data' => [],
                ], 409);
            }
        } else {
            //return error message
            return response()->json([
                'status' => 'failed',
                'message' => "User tidak ditemukan",
                'data' => [],
            ], 400);
        }
    }

    /**
     * Get all premium users.
     *
     * @return Response
     */
    public function getAllPremiumUsers()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Premium Users Requested !',
            'data' => PremiumUser::with('user')->get(),
        ], 200);
    }

    /**
     * Get all premium users.
     *
     * @return Response
     */
    public function getPremiumUserById($id)
    {
        $premiumUser = PremiumUser::with('user')->find($id);
        if ($premiumUser) {
            return response()->json([
                'status' => 'success',
                'message' => 'Premium Users Requested !',
                'data' => $premiumUser,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Premium User Not Found!',
                'data' => [],
            ], 400);
        }
    }

    /**
     * Update premium users
     *
     * @return Response
     */
    public function updatePremiumUser(Request $request, $id)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'payment_date' => "required|date",
            'from' => "required|date",
            'to' => "required|date",
        ]);

        if ($validator->fails()) {
            //return failed response
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        $user = User::find($request->input("user_id"));

        if ($user) {
            try {
                $premiumUser = PremiumUser::find($id);
                $premiumUser->user_id = $request->input("user_id");
                $premiumUser->payment_date = $request->input("payment_date");
                $premiumUser->from = $request->input("from");
                $premiumUser->to = $request->input("to");
                $premiumUser->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Premium User Updated !',
                    'data' => $premiumUser,
                ], 201);
            } catch (\Exception $e) {
                //return error message
                return response()->json([
                    'status' => 'failed',
                    'message' => $e,
                    'data' => [],
                ], 409);
            }
        } else {
            //return error message
            return response()->json([
                'status' => 'failed',
                'message' => "User tidak ditemukan",
                'data' => [],
            ], 400);
        }
    }

    public function deletePremiumUser($id)
    {
        $premiumUser = PremiumUser::find($id);
        if ($premiumUser) {
            $premiumUser->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Premium User Deleted !',
                'data' => [],
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Premium User Not Found!',
                'data' => [],
            ], 400);
        }
    }


    //  ===================================================================================
    //  ==================================== Target  ======================================
    //  ===================================================================================

    public function getAllTarget()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Target Requested !',
            'data' => Target::get(),
        ], 200);
    }

    public function updateTarget(Request $request, $id)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'target' => "required|integer",
            'input' => "integer",
        ]);

        $request = $request->all();

        if ($validator->fails()) {
            //return failed response
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        } else {
            try {
                $target = Target::find($id);
                $target->target = $request['target'];

                if (isset($request['input'])) {
                    $target->input = $request['input'] == 0 ? null : $request['input'];
                }
                $target->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Target Updated !',
                    'data' => $target,
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

    public function getTargetById($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Target Requested !',
            'data' => Target::find($id),
        ], 200);
    }
}
