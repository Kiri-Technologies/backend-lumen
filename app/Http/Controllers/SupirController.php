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



    /**
     * Create Riwayat
     *
     * @return $angkot
     */
    public function createHistory(Request $request){
        try{
            $user_id = $request->input('user_id');
            $angkot_id = $request->input('angkot_id');
            $jumlah_pendapatan = $request->input('jumlah_pendapatan');
            $waktu_narik = $request->input('waktu_narik');
            $selesai_narik = $request->input('selesai_narik');

            $riwayat = new Riwayat();
            $riwayat->user_id = $user_id;
            $riwayat->angkot_id = $angkot_id;
            $riwayat->jumlah_pendapatan = $jumlah_pendapatan;
            $riwayat->waktu_narik = $waktu_narik;
            $riwayat->selesai_narik = $selesai_narik;
            $riwayat->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data created',
                'data' => $riwayat,
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
