<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;


use App\Models\Vehicle;
use App\Models\ListDriver;
use App\Models\History;


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
            'supir_yg_beroperasi' => 'required',
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

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Operation Updated !',
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
    {
        try {
            $user_id = $request->input('user_id');
            $angkot_id = $request->input('angkot_id');
            $jumlah_pendapatan = $request->input('jumlah_pendapatan');
            $waktu_narik = $request->input('waktu_narik');
            $selesai_narik = $request->input('selesai_narik');

            $history = new History();
            $history->user_id = $user_id;
            $history->angkot_id = $angkot_id;
            $history->jumlah_pendapatan = $jumlah_pendapatan;
            $history->waktu_narik = $waktu_narik;
            $history->selesai_narik = $selesai_narik;
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

    /**
     * Update History
     *
     * @return $vehicle
     */
    public function UpdateHistory(Request $request, $id)
    {
        History::find($id)->update($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'data updated'
        ], 201);
    }
}
