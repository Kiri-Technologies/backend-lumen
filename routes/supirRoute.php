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
        //  ======================== SUPIR ==============================
        //  =============================================================

        $router->group(['prefix' => 'supir', 'middleware' => 'supir_auth'], function () use ($router) {

            //  ====================== ANGKOT ============================

            $router->group(["prefix" => 'angkot'], function () use ($router) {

                // Matches /api/supir/angkot/{id}/updateStatusApproval
                // Function : Update angkot supir and operation status
                $router->post('/{id}/updateStatusOperasi', 'SupirController@updateStatusOperasi');
            });

            //  ====================== RIWAYAT ============================

            $router->group(["prefix" => 'riwayat'], function () use ($router) {

                // Matches /api/supir/riwayat/create
                // Function : Create a new data
                $router->post('/create', 'SupirController@CreateHistory');

                // Matches /api/supir/riwayat/{id}/update
                // Function : Update data by Id
                $router->post('/{id}/update', 'SupirController@UpdateHistory');
            });

            //  ====================== CONFIRM ============================
            $router->group(["prefix" => 'driver'], function () use ($router) {

                // Matches /api/supir/driver/{id}/confirm
                // Function : Confirm driver
                $router->post('/{id}/confirm', 'SupirController@confirmSupir');
            });

            //  ====================== PREMIUM USER ============================
            $router->group(["prefix" => 'premiumuser'], function () use ($router) {

                // Matches /api/supir/driver/{id}/confirm
                // Function : Confirm driver
                $router->post('/check', 'SupirController@checkPremiumUser');
            });
        });

        // ==============================================================
        //  ====================== END SUPIR ============================
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
