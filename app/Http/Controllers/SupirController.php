<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;


use App\Models\Vehicle;
use App\Models\ListDriver;
use App\Models\History;
use App\Models\PremiumUser;
use App\Models\Trip;
use Carbon\Carbon;

class SupirController  extends Controller
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
    //  ======================================== ANGKOT ===================================
    //  ===================================================================================

    /**
     * Update vehicle operation and supir
     *
     * @return $vehicle
     */
    public function updateStatusOperasi(Request $request, $id)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'is_beroperasi' => 'required',
            // 'supir_yg_beroperasi' => 'required',
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
                $vehicle->is_beroperasi = $request->input('is_beroperasi');
                $vehicle->supir_id = $request->input('supir_yg_beroperasi');
                $vehicle->save();

                if ($request->input('is_beroperasi') == 0) {
                    $history = History::where('angkot_id', $id)->orderBy('id', 'desc')->first();
                    $history->jumlah_pendapatan = Trip::where('history_id', $history->id)->where('is_connected_with_driver', 1)->sum('rekomendasi_harga');
                    $history->save();
                }

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Operation Updated !',
                    'data' => $vehicle,
                ], 200);
            } catch (\Exception $e) {
                //return error message
                return response()->json([
                    'status' => 'failed',
                    'message' => $e,
                    'data' => [],
                ], 400);
            }
        }
    }

    /**
     * Confirm supir assign to specified angkot
     *
     * @param  int  $id
     */
    public function confirmSupir(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'is_confirmed' => 'required|boolean',
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
                $supir = ListDriver::find($id);
                $supir->is_confirmed = $request->input('is_confirmed');
                $supir->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'supir is confrimed!',
                    'data' => $supir,
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
    //  ======================================= HISTORY ===================================
    //  ===================================================================================



    /**
     * Create History
     *
     * @return $vehicle
     */
    public function createHistory(Request $request)
    { //validate incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'angkot_id' => 'required',
            'mulai_narik' => 'required',
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
                $user_id = $request->input('user_id');
                $angkot_id = $request->input('angkot_id');
                $mulai_narik = $request->input('mulai_narik');

                $history = new History();
                $history->user_id = $user_id;
                $history->angkot_id = $angkot_id;

                if ($request->input('jumlah_pendapatan')) {
                    $jumlah_pendapatan = $request->input('jumlah_pendapatan');
                    $history->jumlah_pendapatan = $jumlah_pendapatan;
                }

                if ($request->input('selesai_narik')) {
                    $selesai_narik = $request->input('selesai_narik');
                    $history->selesai_narik = $selesai_narik;
                }

                $history->mulai_narik = $mulai_narik;
                $history->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data created',
                    'data' => $history,
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
     * Update History
     *
     * @return $vehicle
     */
    public function UpdateHistory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'prohibited',
            'angkot_id' => 'prohibited',
            'mulai_narik' => 'prohibited',
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
                $history = History::find($id);

                if ($request->input('jumlah_pendapatan')) {
                    $history->jumlah_pendapatan = $request->input('jumlah_pendapatan');
                }

                if ($request->input('selesai_narik')) {
                    $history->selesai_narik = $request->input('selesai_narik');
                }

                if ($request->input('status')) {
                    $history->status = $request->input('status');
                }

                $history->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data created',
                    'data' => $history,
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
    //  ================================== PREMIUM USER ===================================
    //  ===================================================================================

    public function checkPremiumUser(Request $request){
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
        }

        try {
            $user_id = $request->input('user_id');
            $thisDate = Carbon::now();
            $premium = PremiumUser::where('user_id', $user_id)->whereDate('to', '>', $thisDate)->first();

            if ($premium) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Premium User Checked',
                    'data' => [
                        'is_premium' => true,
                        'user' => $premium,
                    ],
                ], 200);
            }else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Premium User Checked',
                    'data' => [
                        'is_premium' => false,
                        'user' => [],
                    ],
                ], 200);
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
}
