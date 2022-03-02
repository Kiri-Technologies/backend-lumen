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

        // Matches /api/profile
        // Function : Get User Profile
        $router->get('profile', 'UserController@profile');

        // Matches /api/profile/update
        // Function : Update User Profile
        $router->post('profile/update', 'UserController@updateUser');

        // Matches /api/logout
        // Function : Logout
        $router->post('logout', 'UserController@updateUser');

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
            $router->delete('users/{id}/update', 'AdminController@updateUser');

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
