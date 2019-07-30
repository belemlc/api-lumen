<?php
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;


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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', 'AuthController@login');

$router->get('/me', ['middleware' => 'auth:api', 'uses' => 'AuthController@me']);

$router->post('/users', ['uses' => 'UserController@create']);

$router->get('/login/forgot', 'AuthController@forgot');

$router->post('/login/reset/{token}', ['as' => 'password.reset', 'uses' => 'AuthController@reset']);

// $router->get('/mail', function() {
//     Mail::to(['belemlc@gmail.com'])->send(new ResetPassword);

//     return new ResetPassword;
// });

