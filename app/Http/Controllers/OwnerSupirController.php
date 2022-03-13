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
    public function getListSupir() {
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
    public function deleteSupir($id) {
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
