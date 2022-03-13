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
use App\Models\FeedbackApp;
use App\Models\ListSupir;
use App\Models\Perjalanan;
use App\Models\Riwayat;
use App\Models\Routes;
use App\Models\Setpoints;
use App\Models\User;

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

    /**
     * Create a new Angkot
     *
     * @return void
     */
    public function create(Request $request)
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
                $angkot = new Angkot;
                $angkot->user_id = $request->input('user_id');
                $angkot->route_id = $request->input('route_id');
                $angkot->plat_nomor = $request->input('plat_nomor');
                $angkot->pajak_tahunan = $request->input('pajak_tahunan');
                $angkot->pajak_stnk = $request->input('pajak_stnk');
                $angkot->kir_bulanan = $request->input('kir_bulanan');
                $angkot->status = "pending";
                $angkot->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Created !',
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

    public function update(Request $request, $id)
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
                $angkot = Angkot::find($id);
                $angkot->route_id = $request->input('route_id');
                $angkot->plat_nomor = $request->input('plat_nomor');
                $angkot->pajak_tahunan = $request->input('pajak_tahunan');
                $angkot->pajak_stnk = $request->input('pajak_stnk');
                $angkot->kir_bulanan = $request->input('kir_bulanan');
                $angkot->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Updated !',
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
     * Create a supir on the specified angkot.
     *
     * @param  int  $id
     * @return Response
     */
    public function createSupir(Request $request)
    {
        //validate incoming request
        $validator = Validator::make($request->all(), [
            'supir_id' => 'required',
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
                $supir = new ListSupir;
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
     * Get list supir on the specified angkot.
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
     * Delete supir on the specified angkot.
     *
     * @param int $id
     * @return Response
     */
    public function deleteSupir($id)
    {
        $supir = ListSupir::find($id);
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
