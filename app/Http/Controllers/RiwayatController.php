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
        $this->middleware('supir_auth');
    }

    
// ==============================================================
//  ================= Get All And Get By Params =================
//  =============================================================

    public function getAll(){
        // memvalidasi jika bukan params angkot_id or supir_id
        if(request()->all()){
            if(!request(['angkot_id', 'supir_id'])){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'params not available',
                ], 400);
            }
        }
        
        // fungsi method filter sebenar nya bukan ngequery tapi untuk memfilter sesuai params
        // makanya aku taruh di models aja biar aku gak pusing
        // untuk proses query tetap disini dan disimpan ke dalam $riwayat
        $riwayat =  Riwayat::with('supir')->filter(request(['angkot_id', 'supir_id']))->get();

        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $riwayat
        ], 200); 
    }
    

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
    public function createHistory(Request $request){
        try{
            $user_id = $request->input('user_id');
            $angkot_id = $request->input('angkot_id');
            $jumlah_pendapatan = $request->input('jumlah_pendapatan');
            $waktu_narik = $request->input('waktu_narik');
            $selesai_narik = $request->input('selesai_narik');
    
            Riwayat::create([
                'user_id' => $user_id,
                'angkot_id' => $angkot_id,
                'jumlah_pendapatan' => $jumlah_pendapatan,
                'waktu_narik' => $waktu_narik,
                'selesai_narik' => $selesai_narik
            ]);
    
            return response()->json([
                'message' => 'Data created',
                'data' => []
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
