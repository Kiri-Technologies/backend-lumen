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

        //  ====================== PERJALANAN FAVOURITES ============================
        $router->group(["prefix" => 'perjalananfavorit'], function () use ($router) {

            // Matches /api/perjalananfavorit/create
            // Function : create feedback for application
            $router->post('/create', 'UserController@createPerjalananFavorites');

            // Matches /api/perjalananfavorit/
            // Function : get all perjalanan favorites
            $router->get('/', 'UserController@getPerjalananFavorites');

            // Matches /api/perjalananfavorit/{id}/delete
            // Function : delete perjalanan favorites
            $router->delete('/{id}/delete', 'UserController@deletePerjalananFavorites');
        });

        //  ====================== Routes ============================
        $router->group(["prefix" => 'routes'], function () use ($router) {

            // Matches /api/routes
            // Function : create feedback for application
            $router->get('/', 'UserController@getAllRoutes');
        });

        //  ======================== Halte Virtual ========================

        $router->group(["prefix" => "haltevirtual"], function () use ($router) {

            // Matches /api/hartevirtual/{id}
            // Function : Get Halte Virtual By Id
            $router->get("/{id}", 'UserController@getByIdHalteVirtual');

            // Matches /api/hartevirtual?route_id=
            // Function : Get Halte Virtual By route_id
            $router->get("/", 'UserController@getByRouteIdHalteVirtual');
        });
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
