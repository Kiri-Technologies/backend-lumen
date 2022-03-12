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
use App\Models\ListSupir;

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

    /**
     * Update angkot operation and supir
     *
     * @return $angkot
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
                $angkot = Angkot::find($id);
                $angkot->is_beroperasi = $request->input('is_beroperasi');
                $angkot->supir_id = $request->input('supir_yg_beroperasi');
                $angkot->save();

                //return successful response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Angkot Operation Updated !',
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
