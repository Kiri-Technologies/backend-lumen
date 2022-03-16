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

// Matches /
// Function : Hit Point
$router->get('/', function () use ($router) {
    return "Dont't forget to add '/api' after base url :D";
});

// ==============================================================
//  ====================== MODULE HISTORY =======================
//  =============================================================

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    // ==============================================================
    //  ========================== API ==============================
    //  =============================================================

    // Matches /api
    // Function : API Main Point
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    // Matches /api/register
    // Function : Register
    $router->post('register', 'AuthController@register');

    // Matches /api/login
    // Function : Login
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


            // Matches /api/angkot/getAngkotFind
            // Function : Get all find by owner_id or route_id or status
            $router->get('/find', 'UserController@getAngkotFind');

            // Matches /api/angkot/{id}
            // Function : Find specific angkot by id
            $router->get('/{id}', 'UserController@getAngkotByID');
        });

        //  ====================== PERJALANAN ============================

        $router->group(["prefix" => 'perjalanan'], function () use ($router) {

            // Matches /api/perjalanan/create
            // Function : Create new perjalanan
            $router->post('/create', 'UserController@createPerjalanan');

            // Matches /api/perjalanan/getPerjalananSorting
            // Function : Get all perjalanan sorted by owner_id
            $router->get('/find', 'UserController@getPerjalananFind');

            // Matches /api/perjalanan/{id}/update
            // Function : Update perjalanan
            $router->post('/{id}/update', 'UserController@updatePerjalanan');

            // Matches /api/perjalanan/{id}
            // Function : Get all perjalanan by owner_id
            $router->get('/{id}', 'UserController@getPerjalananByID');

        });

        //  ====================== FEEDBACK ============================

        $router->group(["prefix" => 'feedback'], function () use ($router) {

            // Matches /api/feedback/{id}
            // Function : get feedback find
            $router->get('/{id}', 'UserController@getFeedbackByID');

            // Matches /api/feedback/create
            // Function : create feedback
            $router->post('/create', 'UserController@createFeedback');

            // Matches /api/feedback/{id}/update
            // Function : update feedback
            $router->post('/{id}/update', 'UserController@updateFeedback');

        });

        //  ====================== FEEDBACK APP ============================
        $router->group(["prefix" => 'feedbackapp'], function () use ($router) {

            // Matches /api/feedbackapp/create
            // Function : create feedback for application
            $router->post('/create', 'UserController@createAppFeedback');
        });

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
                $router->patch('/{id}/update', 'SupirController@UpdateHistory');
            });
        });

        // ==============================================================
        //  ====================== END SUPIR ============================
        //  =============================================================

        // ==============================================================
        //  ======================== OWNER ==============================
        //  =============================================================

        $router->group(['prefix' => 'owner', 'middleware' => 'owner_auth'], function () use ($router) {

            //  ====================== ANGKOT ============================

            $router->group(["prefix" => 'angkot'], function () use ($router) {

                // Matches /api/owner/angkot/create
                // Function : Create Angkot
                $router->post('/create', 'OwnerController@create');

                // Matches /api/owner/angkot/{id}/update
                // Function : Create Angkot
                $router->post('/{id}/update', 'OwnerController@update');

                // Matches /api/owner/angkot/{id}/delete
                // Function : Create Angkot
                $router->delete('/{id}/delete', 'OwnerController@deleteAgkot');
            });

            //  ========================= DRIVER =========================

            $router->group(["prefix" => 'driver'], function () use ($router) {

                // Matches /api/owner/driver/create
                // Function : Create Supir
                $router->post('/create', 'OwnerController@createSupir');

                // Matches /api/owner/driver/delete/{id}
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

            //  ========================= DRIVER =========================

            $router->group(["prefix" => 'driver'], function () use ($router) {

                // Matches /api/ownersupir/driver
                // Function : Get List Supir
                $router->get('/', 'OwnerSupirController@getListSupir');
            });

            //  ======================== RIWAYAT ========================

            $router->group(["prefix" => 'riwayat'], function () use ($router) {

                // Matches /api/ownersupir/riwayat/{id}
                // Function : Get Data History By Id
                $router->get('/{id}', 'OwnerSupirController@getById');
            });
        });

        // ==============================================================
        //  ==================== END SUPIR & OWNER ======================
        //  =============================================================


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

            //  ========================= RIWAYAT =========================

            $router->group(["prefix" => 'riwayat'], function () use ($router) {

                // Matches /api/admin/riwayat & /api/admin/riwayat?angkot_id = {id} || ?supir_id = {id}
                // Function: Get All data sekaligus mencari data melalui parameter angkot_id atau supir_id
                $router->get('/', 'AdminController@getAll');
            });

            //  ========================= PERJALANAN =========================

            $router->group(["prefix" => 'perjalanan'], function () use ($router) {

                // Matches /api/admin/perjalanan
                // Function : Get all perjalanan
                $router->get('/', 'AdminController@getAllPerjalanan');
            });

            //  ========================= RUTE =========================

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
            //  ========================= FEEDBACK APP =========================

            $router->group(["prefix" => 'feedbackapp'], function () use ($router) {

                // Matches /api/admin/feedbackapp/{id}/update
                // Function : Update feedback app by id
                $router->post('/{id}/update', 'AdminController@updateAppFeedback');

                // Matches /api/feedbackapp
                // Function : get all feedback for application
                $router->get('/all', 'AdminController@getAllAppFeedback');
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
