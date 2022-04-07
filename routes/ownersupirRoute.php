<?php


/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    // ==============================================================
    //  ========================== API ==============================
    //  =============================================================

    //  =============================================================
    //  ========================= AUTH ==============================
    //  =============================================================

    $router->group(['middleware' => 'auth'], function () use ($router) {

        // ==============================================================
        //  ======================== SUPIR & OWNER ======================
        //  =============================================================

        $router->group(['prefix' => 'ownersupir', 'middleware' => 'owner_supir_auth'], function () use ($router) {

            //  ========================= DRIVER =========================

            $router->group(["prefix" => 'driver'], function () use ($router) {

                // Matches /api/ownersupir/driver
                // Function : Get List Supir
                $router->get('/', 'OwnerSupirController@getListDriver');
            });

            //  ======================== RIWAYAT ========================

            $router->group(["prefix" => 'riwayat'], function () use ($router) {
                // Matches /api/ownersupir/riwayat/find?angkot_id = {id} || ?supir_id = {id}
                // Function: Get data berdasarkan parameter angkot_id atau supir_id
                $router->get('/find', 'OwnerSupirController@findRiwayat');

                // Matches /api/ownersupir/riwayat/{id}
                // Function : Get Data History By Id
                $router->get('/{id}', 'OwnerSupirController@getById');
            });

            //  ========================= Chart =========================
            $router->group(["prefix" => 'chart'], function () use ($router) {

                // Matches /api/ownersupir/chart/totalPendapatan?supir_id/angkot_id/owner_id
                // Function : Get Total Pendapatan
                $router->get('/totalPendapatan', 'OwnerSupirController@getTotalPendapatan');

                // Matches /api/ownersupir/chart/chart/pendapatanHariIni?supir_id/angkot_id/owner_id
                // Function : Get Pendapatan Hari Ini
                $router->get('/pendapatanHariIni', 'OwnerSupirController@getPendapatanHariIni');

                // Matches /api/ownersupir/chart/pendapatanHarian?angkot_id/supir_id/owner_id
                // Function : Get Pendapatan Selama 7 Hari
                $router->get('/pendapatanHarian', 'OwnerSupirController@getPendapatanSelama7HariLalu');

                // Matches /api/ownersupir/chart/averagePenumpangPernarik?angkot_id/supir_id/owner_id
                // Function : Get Avarage Penumpang Pernarik
                $router->get('/averagePenumpangPernarik', 'OwnerSupirController@averagePenumpangPernarik');

                // Matches /api/ownersupir/chart/totalPenumpangHariIni?angkot_id/supir_id/owner_id
                // Function : Get Total Penumpang Hari Ini
                $router->get('/totalPenumpangHariIni', 'OwnerSupirController@totalPenumpangHariIni');
            });
        });

        // ==============================================================
        //  ==================== END SUPIR & OWNER ======================
        //  =============================================================
    });

    //  =============================================================
    //  ======================= END AUTH ============================
    //  =============================================================
});

    // ==============================================================
    //  ======================== END API ============================
    //  =============================================================

// =====================================================================================================================================================================================================
// =====================================================================================================================================================================================================
// =====================================================================================================================================================================================================
