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
        $router->get('profile', 'UserController@profile');

        // Matches /api/update
        $router->post('profile/update', 'UserController@updateUser');

        // Matches /api/users/1
        //get one user by id
        // $router->get('users/{id}', 'UserController@singleUser');

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
            $router->post('angkot/create', 'OwnerController@create');
        });

        // ==============================================================
        //  ======================== ADMIN ==============================
        //  =============================================================

        $router->group(['prefix' => 'admin', 'middleware' => 'admin_auth'], function () use ($router) {

            // Matches /api/admin/users
            $router->get('users', 'AdminController@allUsers');

            // Matches /api/admin/deleteUser/{id}
            $router->delete('deleteUser/{id}', 'AdminController@deleteUser');

            // Matches /api/admin/findUser
            $router->get('findUser', 'AdminController@findUser');

            // Matches /api/admin/angkot
            $router->get('angkot', 'AdminController@allAngkot');
        });
    });
});
