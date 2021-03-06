<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Models\Vehicle;
use App\Models\Favorites;
use App\Models\FeedbackApp;
use App\Models\ListDriver;
use App\Models\History;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;

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

    //  ==================================================================================
    //  ======================================= DRIVER ===================================
    //  ==================================================================================

    /**
     * Get list supir on the specified vehicle.
     *
     * @return Response
     */
    public function getListDriver(Request $request)
    {
        // $list_supir = ListDriver::with('user')->get();
        $list_supir = ListDriver::with('user', 'vehicle.route')
            ->when($request->supir_id, function ($query, $supir_id) {
                return $query->where('supir_id', $supir_id);
            })->when($request->angkot_id, function ($query, $angkot_id) {
                return $query->where('angkot_id', $angkot_id);
            })->when($request->is_confirmed, function ($query, $is_confirmed) {
                return $query->where('is_confirmed', $is_confirmed);
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

    //  ===================================================================================
    //  ======================================= HISTORY ===================================
    //  ===================================================================================

    /**
     * get history supir narik by id
     *
     * @param int $id
     * @return Response
     */
    public function getById(History $history, $id)
    {
        $history =  History::with('supir', 'vehicle.route')->get();
        return response()->json([
            'data' => $history->find($id)
        ]);
    }


    /**
     * Get all history
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
        $history =  History::with('supir', 'vehicle.route')->filter(request(['angkot_id', 'supir_id']))->get();

        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'data' => $history
        ], 200);
    }

    //  ===============================================================================
    //  ================================= CHART =======================================
    //  ===============================================================================

    /**
     * Get Total Pendapatan
     * @return Response
     */
    public function getTotalPendapatan(Request $request)
    {
        $history = History::with('vehicle')->when($request->supir_id, function ($query, $supir_id) {
            return $query->where('user_id', $supir_id);
        })->when($request->angkot_id, function ($query, $angkot_id) {
            return $query->where('angkot_id', $angkot_id);
        })->get();

        $total = $history->sum('jumlah_pendapatan');

        if ($request->owner_id) {
            $new_history = new Collection();
            foreach ($history as $tr) {
                if ($tr->vehicle->user_id == $request->owner_id) {
                    $new_history->push($tr);
                }
            }
            $total = $new_history->sum('jumlah_pendapatan');
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Total Pendapatan Requested !',
            'data' => [
                'total_pendapatan' => $total
            ]
        ], 200);
    }

    /**
     * Get Pendapatan Hari Ini
     * @return Response
     */
    public function getPendapatanHariIni(Request $request)
    {
        $history = History::with('vehicle')->when($request->supir_id, function ($query, $supir_id) {
            return $query->where('user_id', $supir_id);
        })->when($request->angkot_id, function ($query, $angkot_id) {
            return $query->where('angkot_id', $angkot_id);
        })->whereDate('created_at', Carbon::now())->get();

        $total = $history->sum('jumlah_pendapatan');

        if ($request->owner_id) {
            $new_history = new Collection();
            foreach ($history as $tr) {
                if ($tr->vehicle->user_id == $request->owner_id) {
                    $new_history->push($tr);
                }
            }
            $total = $new_history->sum('jumlah_pendapatan');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Total Pendapatan Requested !',
            'data' => $total
        ], 200);
    }

    public function getPendapatanSelama7HariLalu(Request $request)
    {
        for ($day = 0; $day < 7; $day++) {
            $date = Carbon::now()->subDays($day);
            $history = History::with('vehicle')->when($request->supir_id, function ($query, $supir_id) {
                return $query->where('user_id', $supir_id);
            })->when($request->angkot_id, function ($query, $angkot_id) {
                return $query->where('angkot_id', $angkot_id);
            })->whereDate('created_at', $date)
                ->get();

            if ($request->owner_id) {
                $new_history = new Collection();
                foreach ($history as $tr) {
                    if ($tr->vehicle->user_id == $request->owner_id) {
                        $new_history->push($tr);
                    }
                }
                $history = $new_history;
            }
            $total = $history->sum('jumlah_pendapatan');
            $total_pendapatan_7_hari_lalu[] = $total;
        }

        $pendapatan = [
            '1' => $total_pendapatan_7_hari_lalu[0],
            '2' => $total_pendapatan_7_hari_lalu[1],
            '3' => $total_pendapatan_7_hari_lalu[2],
            '4' => $total_pendapatan_7_hari_lalu[3],
            '5' => $total_pendapatan_7_hari_lalu[4],
            '6' => $total_pendapatan_7_hari_lalu[5],
            '7' => $total_pendapatan_7_hari_lalu[6]
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Total Pendapatan Requested !',
            'data' => $pendapatan
        ], 200);
    }

    /**
     * Get Average Penumpang
     * @return Response
     */
    public function averagePenumpangPernarik(Request $request)
    {
        $history = History::with('vehicle')->when($request->supir_id, function ($query, $supir_id) {
            return $query->where('user_id', $supir_id);
        })->when($request->angkot_id, function ($query, $angkot_id) {
            return $query->where('angkot_id', $angkot_id);
        })->get();

        if ($history) {
            if ($request->owner_id) {
                $new_history = new Collection();
                foreach ($history as $tr) {
                    if ($tr->vehicle->user_id == $request->owner_id) {
                        $new_history->push($tr);
                    }
                }
                $history = $new_history;
            }

            if ($history->count() > 0) {
                $history_count = $history->count();
                $count = 0;
                foreach ($history as $tr) {
                    $count_trip = Trip::where('history_id', $tr->id)->count();
                    $count += $count_trip;
                }
                $count = round($count / $history_count);
            } else {
                $count = 0;
            }
        } else {
            $count = 0;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Average Penumpang Requested !',
            'data' => $count
        ], 200);
    }

    /**
     * Get Total Penumpang di Hari Ini
     * @return Response
     */
    public function totalPenumpangHariIni(Request $request)
    {
        $history = History::with('vehicle')->when($request->supir_id, function ($query, $supir_id) {
            return $query->where('user_id', $supir_id);
        })->when($request->angkot_id, function ($query, $angkot_id) {
            return $query->where('angkot_id', $angkot_id);
        })->whereDate('created_at', Carbon::now())->get();

        if ($request->owner_id) {
            $new_history = new Collection();
            foreach ($history as $tr) {
                if ($tr->vehicle->user_id == $request->owner_id) {
                    $new_history->push($tr);
                }
            }
            $history = $new_history;
        }

        $count = 0;
        foreach ($history as $tr) {
            $count_trip = Trip::where('history_id', $tr->id)->count();
            $count += $count_trip;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Total Penumpang Di Hari Ini Requested !',
            'data' => $count
        ], 200);
    }
}
