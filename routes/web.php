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

// ==============================================================
//  ====================== By Wahyu =============================
//  =============================================================

$router->group(["prefix" => 'driverhistory'], function () use ($router) {

    $router->group(['middleware' => 'auth'], function () use ($router) {

        // Matches /driverhistory & /driverhistory?angkot_id = {id} || ?supir_id = {id}
        // Function: Get All data sekaligus mencari data melalui parameter angkot_id atau supir_id
        $router->get('/', 'RiwayatController@getAll');

        // Matches /driverhistory/{id}
        // Function : Get Data History By Id
        $router->get('/{id}', 'RiwayatController@getById');

        // Matches /driverhistory/create
        // Function : Create a new data
        $router->post('/create', 'RiwayatController@CreateHistory');

        // Matches /driverhistory/{id}/update
        // Function : Update data by Id
        $router->patch('/{id}/update', 'RiwayatController@UpdateHistory');
    });
});


// ==============================================================
//  ================= Default From Bang Faiz ===================
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

        // Matches /api/admin/angkot/getAngkotSorting
        // Function : Get all angkot sorted by owner_id
        $router->get('angkot/getAngkotSorting', 'UserController@getAngkotSorting');

        // Matches /api/admin/angkot/owner_id/{id}
        // Function : Find specific angkot by owner_id
        $router->get('angkot/owner_id/{id}', 'UserController@getAngkotByOwnerID');

        // Matches /api/profile
        // Function : Get User Profile
        $router->get('profile', 'UserController@profile');

        // Matches /api/profile/update
        // Function : Update User Profile
        $router->post('profile/update', 'UserController@updateUser');

        // Matches /api/logout
        // Function : Logout
        $router->get('logout', 'UserController@logout');

        // ==============================================================
        //  ======================== SUPIR ==============================
        //  =============================================================

        $router->group(['prefix' => 'supir', 'middleware' => 'supir_auth'], function () use ($router) {
            //

        });

        // ==============================================================
        //  ====================== END SUPIR ============================
        //  =============================================================

        // ==============================================================
        //  ======================== OWNER ==============================
        //  =============================================================

        $router->group(['prefix' => 'owner', 'middleware' => 'owner_auth'], function () use ($router) {

            // Matches /api/owner/angkot/create
            // Function : Create Angkot
            $router->post('angkot/create', 'OwnerController@create');
        });

        // ==============================================================
        //  ====================== END OWNER ============================
        //  =============================================================

        // ==============================================================
        //  ======================== SUPIR & OWNER ======================
        //  =============================================================

        // $router->group(['prefix' => 'owner', 'middleware' => 'owner_auth'], function () use ($router) {

        //     // Matches /api/owner/angkot/create
        //     // Function : Create Angkot
        //     $router->post('angkot/create', 'OwnerController@create');
        // });

        // ==============================================================
        //  ==================== END SUPIR & OWNER ======================
        //  =============================================================


        // ==============================================================
        //  ======================== ADMIN ==============================
        //  =============================================================

        $router->group(['prefix' => 'admin', 'middleware' => 'supir_auth'], function () use ($router) {

            //  ===================== U S E R =====================

            // Matches /api/admin/users
            // Function : Get All Users
            $router->get('users', 'AdminController@allUsers');

            // Matches /api/admin/users/find
            // Function : Find All Users by id / roles
            $router->get('users/find', 'AdminController@findUser');

            // Matches /api/admin/{id}/update
            // Function : Update specific users by id
            $router->post('users/{id}/update', 'AdminController@updateUser');

            // Matches /api/admin/{id}/delete
            // Function : Delete specific user by id
            $router->delete('users/{id}/delete', 'AdminController@deleteUser');

            // Matches /api/admin/users/{id}
            // Function : Find specific user by id
            $router->get('users/{id}', 'AdminController@singleUser');

            //  ===================== A N G K O T =====================

            // Matches /api/admin/angkot
            // Function : Get All Angkot
            $router->get('angkot', 'AdminController@allAngkot');
        });

        // ==============================================================
        //  ====================== END ADMIN ============================
        //  =============================================================



        // Matches /api/admin/angkot/{id}
        // Function : Find specific angkot by id
        $router->get('angkot/{id}', 'UserController@getAngkotByID');
    });

    //  =============================================================
    //  ======================= END AUTH ============================
    //  =============================================================
});

    // ==============================================================
    //  ======================== END API ============================
    //  =============================================================
