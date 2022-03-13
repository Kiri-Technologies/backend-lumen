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

// Hit Point
$router->get('/', function () use ($router) {
    return "Dont't forget to add '/api' after base url :D";
});

// ==============================================================
//  ====================== Module History =======================
//  =============================================================

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    // ==============================================================
    //  ========================== API ==============================
    //  =============================================================

    // API Main Point
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    // Matches /api/register
    $router->post('register', 'AuthController@register');

    // Matches /api/login
    $router->post('login', 'AuthController@login');

    //  =============================================================
    //  ========================= AUTH ==============================
    //  =============================================================

    $router->group(['middleware' => 'auth'], function () use ($router) {

        //  ====================== LOGOUT ============================

        // Matches /api/logout
        // Function : Logout
        $router->get('logout', 'UserController@logout');

        //  ====================== PROFILE ============================

        $router->group(["prefix" => 'profile'], function () use ($router) {

            // Matches /api/profile
            // Function : Get User Profile
            $router->get('/', 'UserController@profile');

            // Matches /api/profile/update
            // Function : Update User Profile
            $router->post('/update', 'UserController@updateUser');

            // Matches /api/profile/update/image
            // Function : Update User Profile
            $router->post('/update/image', 'UserController@updateImage');

            // Matches /api/profile/update/password
            // Function : Update User Profile
            $router->post('/update/password', 'UserController@updatePassword');
        });

        //  ====================== ANGKOT ============================

        $router->group(["prefix" => 'angkot'], function () use ($router) {

            // Matches /api/angkot/searchID/{id}
            // Function : Find specific angkot by id
            // $router->get('/searchID/{id}', 'UserController@getAngkotByID');

            // Matches /api//angkot/getAngkotSorting
            // Matches /api/admin/angkot/getAngkotSorting
            // Function : Get all angkot sorted by owner_id
            // $router->get('/getAngkotSorting', 'UserController@getAngkotSorting');

            // Matches /api/angkot/owner_id/{id}
            // Function : Find specific angkot by owner_id -> REVISI
            // $router->get('/owner_id/{id}', 'UserController@getAngkotByOwnerID');

            // Matches /api/angkot/{id}
            // Function : Find specific angkot by id
            $router->get('/{id}', 'UserController@getAngkotByID');
        });

        //  ====================== PERJALANAN ============================

        $router->group(["prefix" => 'perjalanan'], function () use ($router) {

            // Matches /api/perjalanan/{id}
            // Function : Get all perjalanan by owner_id
            $router->get('/{id}', 'UserController@getPerjalananByID');

            // Matches /api/perjalanan/create
            // Function : Create new perjalanan
            $router->post('/create', 'UserController@createPerjalanan');

            // Matches /api/perjalanan/{id}/update
            // Function : Update perjalanan
            $router->post('/{id}/update', 'UserController@updatePerjalanan');

            // Matches /api/perjalanan/getPerjalananSorting
            // Function : Get all perjalanan sorted by owner_id -> REVISI
            // $router->get('/getPerjalananSorting', 'UserController@getPerjalananSorting');

        });

        // ==============================================================
        //  ======================== SUPIR ==============================
        //  =============================================================

        $router->group(['prefix' => 'supir', 'middleware' => 'supir_auth'], function () use ($router) {

            //  ====================== Angkot ============================

            $router->group(["prefix" => 'angkot'], function () use ($router) {

                // Matches /api/supir/angkot/{id}/updateStatusApproval
                // Function : Update angkot supir and operation status
                $router->post('/{id}/updateStatusApproval', 'SupirController@updateStatusOperasi');
            });

            //  ====================== Riwayat ============================

            $router->group(["prefix" => 'riwayat'], function () use ($router) {

                // Matches /api/supir/riwayat/create
                // Function : Create a new data
                $router->post('/create', 'RiwayatController@CreateHistory');
            });
        });

        // ==============================================================
        //  ====================== END SUPIR ============================
        //  =============================================================

        // ==============================================================
        //  ======================== OWNER ==============================
        //  =============================================================

        $router->group(['prefix' => 'owner', 'middleware' => 'owner_auth'], function () use ($router) {

            //  ===================== A N G K O T =====================

            $router->group(["prefix" => 'angkot'], function () use ($router) {

                // Matches /api/owner/angkot/create
                // Function : Create Angkot
                $router->post('/create', 'OwnerController@create');

                // Matches /api/owner/angkot/{id}/update
                // Function : Create Angkot
                $router->post('/{id}/update', 'OwnerController@update');
            });

            //  ===================== D R I V E R =====================

            $router->group(["prefix" => 'driver'], function () use ($router) {

                // Matches /api/owner/driver/create
                // Function : Create Supir
                $router->post('/create', 'OwnerController@createSupir');

                // Matches /api/owner/driver/create{id}
                // Function : Delete Supir
                $router->delete('/delete/{id}', 'OwnerController@deleteSupir');
            });
        });

        // ==============================================================
        //  ====================== END OWNER ============================
        //  =============================================================

        // ==============================================================
        //  ======================== SUPIR & OWNER ======================
        //  =============================================================

        $router->group(['prefix' => 'ownersupir', 'middleware' => 'owner_supir_auth'], function () use ($router) {

            //  ===================== D R I V E R =====================

            $router->group(["prefix" => 'driver'], function () use ($router) {

                // Matches /api/ownersupir/driver
                // Function : Get List Supir
                $router->get('/', 'OwnerSupirController@getListSupir');
            });

        });

        // ==============================================================
        //  ==================== END SUPIR & OWNER ======================
        //  =============================================================


        // ==============================================================
        //  ======================== ADMIN ==============================
        //  =============================================================

        $router->group(['prefix' => 'admin', 'middleware' => 'admin_auth'], function () use ($router) {

            //  ===================== U S E R =====================

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

            //  ===================== A N G K O T =====================

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

            //  ===================== R I W A Y A T =====================

            $router->group(["prefix" => 'riwayat'], function () use ($router) {

                // Matches /api/admin/riwayat & /api/admin/riwayat?angkot_id = {id} || ?supir_id = {id}
                // Function: Get All data sekaligus mencari data melalui parameter angkot_id atau supir_id
                $router->get('/', 'AdminController@getAll');
            });

            //  ================== P E R J A L A N A N ==================

            $router->group(["prefix" => 'perjalanan'], function () use ($router) {

                // Matches /api/admin/perjalanan
                // Function : Get all perjalanan
                $router->get('/', 'AdminController@getAllPerjalanan');
            });

            //  ========================= R U T E ========================

            $router->group(["prefix" => 'routes'], function () use ($router) {

                // Matches /api/admin/routes
                // Function : Get all routes
                $router->get('/', 'AdminController@getAllRoutes');

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

// ==============================================================
//  ====================== By Wahyu =============================
//  =============================================================

// $router->group(["prefix" => 'driverhistory'], function () use ($router) {

//     $router->group(['middleware' => 'auth'], function () use ($router) {

//         // Matches /driverhistory/{id}
//         // Function : Get Data History By Id
//         $router->get('/{id}', 'RiwayatController@getById');

//         // Matches /driverhistory/{id}/update
//         // Function : Update data by Id
//         $router->patch('/{id}/update', 'RiwayatController@UpdateHistory');
//     });
// });
