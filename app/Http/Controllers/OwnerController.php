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
use App\Models\Angkot;

class OwnerController  extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('owner_auth');
    }

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
}
