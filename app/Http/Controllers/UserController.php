<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


use App\Models\Angkot;
use App\Models\Favorites;
use App\Models\Feedback;
use App\Models\FeedbackApp;
use App\Models\ListSupir;
use App\Models\Perjalanan;
use App\Models\Riwayat;
use App\Models\Routes;
use App\Models\Setpoints;
use App\Models\User;

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
                $user = User::find(Auth::user()->id);
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->birthdate = $request->input('birthdate');
                $user->role = $request->input('role');
                $user->no_hp = $request->input('no_hp');
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
     * @param $id
     */
    public function getAngkotByID($id)
    {
        $angkot = Angkot::find($id);
        if (!$angkot) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Angkot Not Found!',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Angkot Requested !',
            'data' => $angkot,
        ], 200);
    }

    /**
     * Get Angkot Find.
     * 
     *
     * @return Response
     */
    public function getAngkotFind(Request $request) {
        $angkot = Angkot::when($request->owner_id, function ($query, $owner_id) {
            return $query->where('user_id', $owner_id);
        })->when($request->route_id, function ($query, $route_id) {
            return $query->where('route_id', $route_id);
        })->when($request->status, function ($query, $status) {
            return $query->where('status', $status);
        })->get();

        if (!$angkot) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Angkot Not Found!',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Angkot Requested !',
            'data' => $angkot,
        ], 200);
        
    }

    /**
     * Create new Perjalanan
     *
     * @return Response
     */
    public function createPerjalanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penumpang_id' => 'required|string',
            'angkot_id' => 'required|string',
            'supir_id' => 'required|string',
            'titik_naik' => 'required|string',
            'titik_turun' => 'required|string',
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
                $perjalanan = new Perjalanan;
                $perjalanan->penumpang_id = $request->input('penumpang_id');
                $perjalanan->angkot_id = $request->input('angkot_id');
                $perjalanan->supir_id = $request->input('supir_id');
                $perjalanan->titik_naik = $request->input('titik_naik');
                $perjalanan->titik_turun = $request->input('titik_turun');
                $perjalanan->jarak = $request->input('jarak');
                $perjalanan->rekomendasi_harga = $request->input('rekomendasi_harga');
                $perjalanan->is_done = $request->input('is_done');
                $perjalanan->is_connected_with_driver = $request->input('is_connected_with_driver');
                $perjalanan->save();

                // return success response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Perjalanan Created !',
                    'data' => $perjalanan,
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
     * Update Perjalanan.
     *
     * @return Response
     *
     */
    public function updatePerjalanan(Request $request, $id)
    {
        $perjalanan = Perjalanan::find($id);
        if (!$perjalanan) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Perjalanan Not Found!',
                'data' => [],
            ], 404);
        }
        if (isset($request->is_connected_with_driver)) {
            $perjalanan->is_connected_with_driver = $request->is_connected_with_driver;
        }
        if (isset($request->is_done)) {
            $perjalanan->is_done = $request->is_done;
        }
        // $perjalanan->is_done = true;
        // $perjalanan->is_connected_with_driver = true;
        $perjalanan->save();

        // return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Perjalanan Updated !',
            'data' => $perjalanan,
        ], 201);
    }

    /**
     * Get Perjalanan Find.
     *
     * @return Response
     *
     */
    public function getPerjalananFind(Request $request)
    {
        $perjalanan = Perjalanan::when($request->penumpang_id, function ($query, $penumpang_id) {
            return $query->where('penumpang_id', $penumpang_id);
        })->when($request->angkot_id, function ($query, $angkot_id) {
            return $query->where('angkot_id', $angkot_id);
        })->when($request->supir_id, function ($query, $supir_id) {
            return $query->where('supir_id', $supir_id);
        })->get();

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
     * Get Perjalanan By ID.
     *
     * @return Response
     * @param $id
     */
    public function getPerjalananByID($id)
    {
        $perjalanan = Perjalanan::find($id);
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
            'data' => $feedback,
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
}
