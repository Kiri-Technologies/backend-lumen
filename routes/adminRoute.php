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
        //  ======================== ADMIN ==============================
        //  =============================================================

        $router->group(['prefix' => 'admin', 'middleware' => 'admin_auth'], function () use ($router) {

            //  ========================= USER =========================

            $router->group(["prefix" => 'users'], function () use ($router) {

                // Matches /api/admin/users
                // Function : Get All Users
                $router->get('/', 'AdminController@allUsers');

                // Matches /api/admin/users/find
                // Function : Find All Users by id / roles
                $router->get('/find', 'AdminController@findUser');

                // Matches /api/admin/{id}/update
                // Function : Update specific users by id
                $router->post('/{id}/update', 'AdminController@updateUser');

                // Matches /api/admin/{id}/delete
                // Function : Delete specific user by id
                $router->delete('/{id}/delete', 'AdminController@deleteUser');

                // Matches /api/admin/users/{id}
                // Function : Find specific user by id
                $router->get('/{id}', 'AdminController@singleUser');
            });

            //  ========================= ANGKOT =========================

            $router->group(["prefix" => 'angkot'], function () use ($router) {

                // Matches /api/admin/angkot
                // Function : Get All Angkot
                $router->get('/', 'AdminController@allAngkot');

                // Matches /api/admin/angkot/{id}/updateStatusApproval
                // Function : Update angkot status
                $router->post('/{id}/updateStatusApproval', 'AdminController@updateStatusApproval');

                // Matches /api/owner/angkot/{id}/delete
                // Function : Delete angkot by id
                $router->post('/{id}/delete', 'AdminController@DeleteAngkotById');
            });

            //  ========================= PERJALANAN =========================

            $router->group(["prefix" => 'perjalanan'], function () use ($router) {

                // Matches /api/admin/perjalanan
                // Function : Get all perjalanan
                $router->get('/', 'AdminController@getAllPerjalanan');
            });

            //  ========================= RUTE =========================

            $router->group(["prefix" => 'routes'], function () use ($router) {

                // Matches /api/admin/routes/create
                // Function : Update routes by id
                $router->post('/create', 'AdminController@createRoutes');

                // Matches /api/admin/routes/{id}/update
                // Function : Update routes by id
                $router->post('/{id}/update', 'AdminController@updateRoutes');

                // Matches /api/admin/routes/{id}/delete
                // Function : delete routes by id
                $router->post('/{id}/delete', 'AdminController@deleteRoutes');
            });
            //  ========================= FEEDBACK APP =========================

            $router->group(["prefix" => 'feedbackapp'], function () use ($router) {

                // Matches /api/admin/feedbackapp/{id}/update
                // Function : Update feedback app by id
                $router->post('/{id}/update', 'AdminController@updateAppFeedback');

                // Matches /api/feedbackapp
                // Function : get all feedback for application
                $router->get('/all', 'AdminController@getAllAppFeedback');

                // Matches /api/feedbackapp/find
                // Function : find feedback app by status
                $router->get('/find', 'AdminController@getAppFeedbackFind');
            });

            //  ========================= FEEDBACK APP =========================

            $router->group(["prefix" => 'riwayat'], function () use ($router) {

                // Matches /api/admin/riwayat
                // Function : Get Data History
                $router->get('/', 'AdminController@allRiwayat');
            });

            //  ======================== Halte Virtual ========================

            $router->group(["prefix" => "haltevirtual"], function () use ($router) {

                // Matches /api/admin/hartevirtual/create
                // Function : Create Halte Virtual
                $router->post("/create", 'AdminController@createHalteVirtual');

                // Matches /api/admin/hartevirtual/{id}/update
                // Function : Update Halte Virtual
                $router->patch("/{id}/update", 'AdminController@updateHalteVirtual');

                // Matches /api/admin/hartevirtual/{id}/delete
                // Function : Delete Halte Virtual
                $router->delete("/{id}/delete", 'AdminController@deleteHalteVirtual');
            });

            //  ======================== Chart ========================
            $router->group(["prefix" => "chart"], function () use ($router) {

                // Matches /api/admin/chart/totalPendapatanBulanIni
                // Function : Get Total Pendapatan Bulan Ini
                $router->get("/totalPendapatanBulanIni", 'AdminController@totalPendapatanBulanIni');

                // Matches /api/admin/chart/totalPendapatanBulanLalu
                // Function : Get Total Pendapatan Bulan Lalu
                $router->get("/totalPendapatanBulanLalu", 'AdminController@totalPendapatanBulanLalu');

                // Matches /api/admin/chart/totalAngkotMendaftarBulanIni
                // Function : Get Total Angkot Mendaftar Bulan Ini
                $router->get("/totalAngkotMendaftarBulanIni", 'AdminController@totalAngkotMendaftarBulanIni');

                // Matches /api/admin/chart/totalFeedbackApp
                // Function : Get Total FeedbackApp Mendaftar Bulan Ini
                $router->get("/totalFeedbackApp", 'AdminController@totalFeedbackApp');

                // Matches /api/admin/chart/totalAngkotTerdaftar
                // Function : Get Total Angkot Terdaftar
                $router->get("/totalAngkotTerdaftar", 'AdminController@totalAngkotTerdaftar');

                // Matches /api/admin/totalusers
                // Function : get total users
                $router->get("/totalUsers", 'AdminController@getTotalUsers');
            });
        });

        // ==============================================================
        //  ====================== END ADMIN ============================
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
