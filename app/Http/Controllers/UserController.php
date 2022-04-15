<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


use App\Models\Vehicle;
use App\Models\Favorites;
use App\Models\Feedback;
use App\Models\Trip;
use App\Models\User;
use App\Models\FeedbackApplication;
use App\Models\Routes;
use App\Models\Setpoints;

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

    //  ===================================================================================
    //  ======================================= PROFILE ===================================
    //  ===================================================================================

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
            'birthdate' => 'required|date',
            'role' => 'required|in:admin,penumpang,owner,supir',
            'phone_number' => 'required',
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
                $user->birthdate = $request->input('birthdate');
                $user->role = $request->input('role');
                $user->phone_number = $request->input('phone_number');
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

    public function updateImage(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
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
                    'message' => 'User Image Updated !',
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

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'password' => 'required',
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
                $user->password = app('hash')->make($request->input('password'));
                $user->save();

                Auth::guard('api')->logout();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Password Updated ! Please Login Again',
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

    //  ===================================================================================
    //  ======================================= LOGOUT ===================================
    //  ===================================================================================

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

    //  ===================================================================================
    //  ======================================== ANGKOT ===================================
    //  ===================================================================================

    /**
     * Get Angkot By ID.
     *
     * @return Response
     * @param $id
     */
    public function getAngkotByID($id)
    {
        $vehicle = Vehicle::with('user_owner', 'route')->find($id);
        if (!$vehicle) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Angkot Not Found!',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Angkot Requested !',
            'data' => $vehicle,
        ], 200);
    }

    /**
     * Get Angkot Find.
     *
     *
     * @return Response
     */
    public function getAngkotFind(Request $request)
    {
        $vehicle = Vehicle::with('user_owner', 'route')->when($request->owner_id, function ($query, $owner_id) {
            return $query->where('user_id', $owner_id);
        })->when($request->route_id, function ($query, $route_id) {
            return $query->where('route_id', $route_id);
        })->when($request->status, function ($query, $status) {
            return $query->where('status', $status);
        })->get();

        if (!$vehicle) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Angkot Not Found!',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Angkot Requested !',
            'data' => $vehicle,
        ], 200);
    }

    //  ===================================================================================
    //  ========================================= TRIP ====================================
    //  ===================================================================================

    /**
     * Create new Trip
     *
     * @return Response
     */
    public function createPerjalanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penumpang_id' => 'required|string',
            'angkot_id' => 'required|string',
            'history_id' => 'required|string',
            'tempat_naik_id' => 'required|string',
            'tempat_turun_id' => 'required|string',
            'supir_id' => 'required|string',
            'nama_tempat_naik' => 'required|string',
            'nama_tempat_turun' => 'required|string',
            'jarak' => 'required|string',
            'rekomendasi_harga' => 'required|string',
            'is_done' => 'required|boolean',
            'is_connected_with_driver' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            // return fails response
            return response()->json([
                'status' => 'fails',
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        } else {
            try {
                $trip = new Trip;
                $trip->penumpang_id = $request->input('penumpang_id');
                $trip->angkot_id = $request->input('angkot_id');
                $trip->history_id = $request->input('history_id');
                $trip->tempat_naik_id = $request->input('tempat_naik_id');
                $trip->tempat_turun_id = $request->input('tempat_turun_id');
                $trip->supir_id = $request->input('supir_id');
                $trip->nama_tempat_naik = $request->input('nama_tempat_naik');
                $trip->nama_tempat_turun = $request->input('nama_tempat_turun');
                $trip->jarak = $request->input('jarak');
                $trip->rekomendasi_harga = $request->input('rekomendasi_harga');
                $trip->is_done = $request->input('is_done');
                $trip->is_connected_with_driver = $request->input('is_connected_with_driver');
                $trip->save();

                // return success response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Trip Created !',
                    'data' => $trip,
                ], 201);
            } catch (\Exception $e) {
                // return error message
                return response()->json([
                    'status' => 'failed',
                    'message' => $e,
                    'data' => [],
                ], 409);
            }
        }
    }

    /**
     * Update Trip.
     *
     * @return Response
     *
     */
    public function updatePerjalanan(Request $request, $id)
    {
        $trip = Trip::with('feedback')->find($id);
        if (!$trip) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Trip Not Found!',
                'data' => [],
            ], 404);
        }
        if (isset($request->is_connected_with_driver)) {
            $trip->is_connected_with_driver = $request->is_connected_with_driver;
        }
        if (isset($request->is_done)) {
            $trip->is_done = $request->is_done;
        }

        $trip->save();

        // return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Trip Updated !',
            'data' => $trip,
        ], 201);
    }

    /**
     * Get Trip Find.
     *
     * @return Response
     *
     */
    public function getPerjalananFind(Request $request)
    {
        $trip = Trip::with('user_penumpang', 'vehicle.route', 'user_supir','feedback')->when($request->penumpang_id, function ($query, $penumpang_id) {
            return $query->where('penumpang_id', $penumpang_id);
        })->when($request->angkot_id, function ($query, $angkot_id) {
            return $query->where('angkot_id', $angkot_id);
        })->when($request->supir_id, function ($query, $supir_id) {
            return $query->where('supir_id', $supir_id);
        })->when($request->is_connected_with_driver, function ($query, $is_connected_with_driver) {
            return $query->where('is_connected_with_driver', $is_connected_with_driver);
        })->when($request->is_done, function ($query, $is_done) {
            return $query->where('is_done', $is_done);
        })->get();



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

    /**
     * Get Trip By ID.
     *
     * @return Response
     * @param $id
     */
    public function getPerjalananByID($id)
    {
        $trip = Trip::with('user_penumpang', 'vehicle.route', 'user_supir','feedback')->find($id);
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

    //  ===================================================================================
    //  ====================================== FEEDBACK ===================================
    //  ===================================================================================

    /**
     * Get Feedback By ID.
     *
     * @return Response
     * @param $id
     */
    public function getFeedbackByID($id)
    {
        $feedback = Feedback::find($id);
        if (!$feedback) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Feedback Not Found!',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Feedback Requested !',
            'data' => [$feedback],
        ], 200);
    }

    /**
     * Create a Feedback.
     *
     * @param  int  $id
     * @return Response
     */
    public function createFeedback(Request $request)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'perjalanan_id' => 'required',
            'rating' => 'required',
            'review' => 'required',
            'komentar' => 'required',
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
                $feedback = new Feedback();
                $feedback->perjalanan_id = $request->input('perjalanan_id');
                $feedback->rating = $request->input('rating');
                $feedback->review = $request->input('review');
                $feedback->komentar = $request->input('komentar');
                $feedback->save();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Feedback Created !',
                    'data' => $feedback,
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
     * Update a Feedback.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateFeedback(Request $request, $id)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'perjalanan_id' => 'required',
            'rating' => 'required',
            'review' => 'required',
            'komentar' => 'required',
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
                $feedback = Feedback::find($id);
                $feedback->perjalanan_id = $request->input('perjalanan_id');
                $feedback->rating = $request->input('rating');
                $feedback->review = $request->input('review');
                $feedback->komentar = $request->input('komentar');
                $feedback->save();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Feedback Updated !',
                    'data' => $feedback,
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

    //  ===================================================================================
    //  ================================== FEEDBACK APP ===================================
    //  ===================================================================================

    /**
     * Create App Feedback
     *
     * @param Request $request
     *
     */
    public function createAppFeedback(Request $request)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'review' => 'required|in:excellent,happy,neutral,sad,awful',
            'tanggapan' => 'required',
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
                $feedback = new FeedbackApplication();
                $feedback->user_id = $request->input('user_id');
                $feedback->review = $request->input('review');
                $feedback->tanggapan = $request->input('tanggapan');
                $feedback->status = "submitted";
                $feedback->save();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Feedback Created !',
                    'data' => $feedback,
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

    //  ===================================================================================
    //  ==================================== FAVORITE =====================================
    //  ===================================================================================

    /**
     * Create Trip Favorites
     *
     * @param Request $request
     */
    public function createPerjalananFavorites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'route_id' => 'required',
            'tempat_naik_id' => 'required',
            'tempat_turun_id' => 'required',
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
                $favorites = new Favorites();
                $favorites->user_id = $request->input('user_id');
                $favorites->route_id = $request->input('route_id');
                $favorites->tempat_naik_id = $request->input('tempat_naik_id');
                $favorites->tempat_turun_id = $request->input('tempat_turun_id');
                $favorites->save();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Trip Favorites Created !',
                    'data' => $favorites,
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
     * Get all Trip Favorites
     * by user_id
     * the user can see trip favorites he created
     *
     * @param Request $request
     *
     */
    public function getPerjalananFavorites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
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
                $favorites = Favorites::where('user_id', $request->input('user_id'))->get();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Trip Favorites Found !',
                    'data' => $favorites,
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
     * Delete Trip Favorites
     *
     * @param Request $request
     *
     */
    public function deletePerjalananFavorites(Request $request, $id)
    {
        try {
            $favorites = Favorites::find($id)->delete();
            // return successful response
            return response()->json([
                'status' => 'success',
                'message' => 'Trip Favorites Deleted !',
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

    //  ===================================================================================
    //  ===================================== ROUTES ======================================
    //  ===================================================================================

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


    //  =============================================================
    //  ===================== HALTE VIRTUAL =========================
    //  =============================================================

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


}
