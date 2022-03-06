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

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    // ==============================================================
    //  ======================== PUBLIC =============================
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


        // Matches /api/angkot/searchID/{id}
        // Function : Find specific angkot by id
        $router->get('angkot/searchID/{id}', 'UserController@getAngkotByID');

        // Matches /api//angkot/getAngkotSorting
        // Function : Get all angkot sorted by owner_id
        $router->get('angkot/getAngkotSorting', 'UserController@getAngkotSorting');

        // Matches /api/angkot/owner_id/{id}
        // Function : Find specific angkot by owner_id
        $router->get('angkot/owner_id/{id}', 'UserController@getAngkotByOwnerID');

        // Matches /apiangkot/createPerjalanan
        // Function : Create new perjalanan
        $router->post('angkot/createPerjalanan', 'UserController@createPerjalanan');

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
        //  ======================== OWNER ==============================
        //  =============================================================

        $router->group(['prefix' => 'owner', 'middleware' => 'owner_auth'], function () use ($router) {

            // Matches /api/owner/angkot/create
            // Function : Create Angkot
            $router->post('angkot/create', 'OwnerController@create');

            // Matches /api/owner/createSupir
            // Function : Create Supir
            $router->post('supir/create', 'OwnerController@createSupir');

            // Matches /api/owner/angkot/getListSupir
            // Function : Get List Supir
            $router->get('angkot/getListSupir', 'OwnerController@getListSupir');

            // Matches /api/owner/angkot/deleteSupir/{id}
            // Function : Delete Supir
            $router->get('angkot/deleteSupir/{id}', 'OwnerController@deleteSupir');
        });

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

        });
    });
});
