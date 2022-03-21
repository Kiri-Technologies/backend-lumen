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

class OwnerSupirController  extends Controller
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
     * Get list supir on the specified angkot.
     *
     * @return Response
     */
    public function getListSupir(Request $request)
    {
        // $list_supir = ListSupir::with('user')->get();
        $list_supir = ListSupir::with('user')
        ->when($request->user_id, function ($query, $user_id) {
            return $query->where('user_id', $user_id);
        })->when($request->angkot_id, function ($query, $angkot_id) {
            return $query->where('angkot_id', $angkot_id);
        })->get();

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

    /**
     * get riwayat supir narik by id
     *
     * @param int $id
     * @return Response
     */
    public function getById(Riwayat $riwayat, $id)
    {
        $riwayat =  Riwayat::with('supir')->get();
        return response()->json([
            'data' => $riwayat->find($id)
        ]);
    }


    /**
     * Get all riwayat
     *
     * @param  int  $id
     * @return Response
     */
    public function findRiwayat()
    {
        // memvalidasi jika bukan params angkot_id or supir_id
        if (request()->all()) {
            if (!request(['angkot_id', 'supir_id'])) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'params not available',
                ], 400);
            }
        }
        $riwayat =  Riwayat::with('supir')->filter(request(['angkot_id', 'supir_id']))->get();

        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $riwayat
        ], 200);
    }
}
