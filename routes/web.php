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

        //  ====================== PROFILE ============================

        // Matches /api/profile
        // Function : Get User Profile
        $router->get('profile', 'UserController@profile');

        // Matches /api/profile/update
        // Function : Update User Profile
        $router->post('profile/update', 'UserController@updateUser');

        // Matches /api/profile/update/image
        // Function : Update User Profile
        $router->post('profile/update/image', 'UserController@updateImage');

        // Matches /api/profile/update/password
        // Function : Update User Profile
        $router->post('profile/update/password', 'UserController@updatePassword');

        // Matches /api/logout
        // Function : Logout
        $router->get('logout', 'UserController@logout');

        //  ====================== ANGKOT ============================

        // Matches /api/angkot/searchID/{id}
        // Function : Find specific angkot by id
        // $router->get('angkot/searchID/{id}', 'UserController@getAngkotByID');

        // Matches /api//angkot/getAngkotSorting
        // Matches /api/admin/angkot/getAngkotSorting
        // Function : Get all angkot sorted by owner_id
        // $router->get('angkot/getAngkotSorting', 'UserController@getAngkotSorting');

        // Matches /api/angkot/owner_id/{id}
        // Function : Find specific angkot by owner_id -> REVISI
        // $router->get('angkot/owner_id/{id}', 'UserController@getAngkotByOwnerID');

        // Matches /api/angkot/{id}
        // Function : Find specific angkot by id
        $router->get('angkot/{id}', 'UserController@getAngkotByID');

        //  ====================== PERJALANAN ============================

        // Matches /api/perjalanan/{id}
        // Function : Get all perjalanan by owner_id
        $router->get('perjalanan/{id}', 'UserController@getPerjalananByID');

        // Matches /api/perjalanan/create
        // Function : Create new perjalanan
        $router->post('perjalanan/create', 'UserController@createPerjalanan');

        // Matches /api/perjalanan/{id}/update
        // Function : Update perjalanan
        $router->post('perjalanan/{id}/update', 'UserController@updatePerjalanan');

        // Matches /api/perjalanan/getPerjalananSorting
        // Function : Get all perjalanan sorted by owner_id -> REVISI
        // $router->get('perjalanan/getPerjalananSorting', 'UserController@getPerjalananSorting');

        // ==============================================================
        //  ======================== SUPIR ==============================
        //  =============================================================

        $router->group(['prefix' => 'supir', 'middleware' => 'supir_auth'], function () use ($router) {

            //  ====================== Riwayat ============================

            // Matches /api/supir/riwayat/create
            // Function : Create a new data
            $router->post('/riwayat/create', 'RiwayatController@CreateHistory');
        });

        // ==============================================================
        //  ====================== END SUPIR ============================
        //  =============================================================

        // ==============================================================
        //  ======================== OWNER ==============================
        //  =============================================================

        $router->group(['prefix' => 'owner', 'middleware' => 'owner_auth'], function () use ($router) {

            //  ===================== A N G K O T =====================

            // Matches /api/owner/angkot/create
            // Function : Create Angkot
            $router->post('angkot/create', 'OwnerController@create');

            //  ===================== D R I V E R =====================

            // Matches /api/owner/driver/create
            // Function : Create Supir
            $router->post('driver/create', 'OwnerController@createSupir');

            // Matches /api/owner/driver/create{id}
            // Function : Delete Supir
            $router->delete('driver/delete/{id}', 'OwnerController@deleteSupir');
        });

        // ==============================================================
        //  ====================== END OWNER ============================
        //  =============================================================

        // ==============================================================
        //  ======================== SUPIR & OWNER ======================
        //  =============================================================

        $router->group(['prefix' => 'ownersupir', 'middleware' => 'owner_supir_auth'], function () use ($router) {

            //  ===================== D R I V E R =====================

            // Matches /api/ownersupir/driver
            // Function : Get List Supir ->
            $router->get('driver', 'OwnerController@getListSupir');
        });

        // ==============================================================
        //  ==================== END SUPIR & OWNER ======================
        //  =============================================================


        // ==============================================================
        //  ======================== ADMIN ==============================
        //  =============================================================

        $router->group(['prefix' => 'admin', 'middleware' => 'admin_auth'], function () use ($router) {

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

            //  ===================== R I W A Y A T =====================

            // Matches /api/admin/riwayat & /api/admin/riwayat?angkot_id = {id} || ?supir_id = {id}
            // Function: Get All data sekaligus mencari data melalui parameter angkot_id atau supir_id
            $router->get('/riwayat', 'RiwayatController@getAll');

            //  ================== P E R J A L A N A N ==================

            // Matches /api/admin/perjalanan
            // Function : Get all perjalanan
            $router->get('perjalanan', 'UserController@getAllPerjalanan');
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
