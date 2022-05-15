<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use App\Models\Vehicle;
use App\Models\ListDriver;

class OwnerController  extends Controller
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

    //  =================================================================================
    //  ====================================== ANGKOT ===================================
    //  =================================================================================

    /**
     * Create a new Angkot
     *
     * @return void
     */
    public function createAngkot(Request $request)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'route_id' => 'required|string',
            'plat_nomor' => 'required|string',
            'pajak_tahunan' => 'required|date',
            'pajak_stnk' => 'required|date',
            'kir_bulanan' => 'required|date',
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
                $vehicle = new Vehicle;
                $vehicle->user_id = $request->input('user_id');
                $vehicle->route_id = $request->input('route_id');
                $vehicle->plat_nomor = $request->input('plat_nomor');
                $vehicle->pajak_tahunan = $request->input('pajak_tahunan');
                $vehicle->pajak_stnk = $request->input('pajak_stnk');
                $vehicle->kir_bulanan = $request->input('kir_bulanan');
                $vehicle->status = "pending";
                $vehicle->save();

                $vehicle->qr_code = 'http://chart.googleapis.com/chart?chs=200x200&cht=qr&chl='.urlencode($_ENV['APP_URL'].'/vehicle/'.$vehicle->id);
                $vehicle->save();


                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Created !',
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

    public function updateAngkot(Request $request, $id)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'route_id' => 'required|string',
            'plat_nomor' => 'required|string',
            'pajak_tahunan' => 'required|date',
            'pajak_stnk' => 'required|date',
            'kir_bulanan' => 'required|date',
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
                $vehicle->route_id = $request->input('route_id');
                $vehicle->plat_nomor = $request->input('plat_nomor');
                $vehicle->pajak_tahunan = $request->input('pajak_tahunan');
                $vehicle->pajak_stnk = $request->input('pajak_stnk');
                $vehicle->kir_bulanan = $request->input('kir_bulanan');
                $vehicle->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Updated !',
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

    public function deleteAgkot(Request $request, $id)
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

    //  =================================================================================
    //  ======================================= SUPIR ===================================
    //  =================================================================================

    /**
     * Create a supir on the specified vehicle.
     *
     * @param  int  $id
     * @return Response
     */
    public function createSupir(Request $request)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'supir_id' => 'required|exists:users,id',
            'angkot_id' => 'required',
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
                $supir = new ListDriver;
                $supir->supir_id = $request->input('supir_id');
                $supir->angkot_id = $request->input('angkot_id');
                $supir->is_confirmed = null;
                $supir->save();

                // return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Supir Created !',
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

    /**
     * Delete supir on the specified vehicle.
     *
     * @param int $id
     * @return Response
     */
    public function deleteSupir($id)
    {
        $supir = ListDriver::find($id);
        if ($supir) {
            $supir->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'supir deleted successfully!',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'supir not found!',
                'data' => [],
            ], 404);
        }
    }


}
