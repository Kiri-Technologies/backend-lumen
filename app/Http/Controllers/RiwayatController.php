<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\User;

class RiwayatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


// ==============================================================
//  ================= Get All And Get By Params =================
//  =============================================================




    // ==============================================================
    //  ========================= Get By Id =========================
    //  =============================================================
    public function getById(Riwayat $riwayat, $id){
        $riwayat =  Riwayat::with('supir')->get();
        return response()->json([
            'data' => $riwayat->find($id)
        ]);
    }

    // ==============================================================
    //  =================== Create New History ======================
    //  =============================================================
    

    // ==============================================================
    //  ================ Update Data History By Id ==================
    //  =============================================================
    public function UpdateHistory(Request $request, $id){
        Riwayat::find($id)->update($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'data updated'
        ], 201);
    }
}
