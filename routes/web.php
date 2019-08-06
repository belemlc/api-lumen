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
    return response()->json('Welcome Hermes API :)', 404);
});

$router->post('/login', 'AuthController@login');

$router->get('/me', ['middleware' => 'auth:api', 'uses' => 'AuthController@me']);

$router->post('/users', ['uses' => 'UserController@create']);

// Cria uma lista de contatos para o usuario
$router->post('/user/{id}/lists', ['middleware' => 'auth:api', 'as' => 'contact-list.create' ,'uses' => 'ContactListController@create']);
// Atualiza uma lista
$router->put('/user/{userid}/list/{listaid}', ['middleware' => 'auth:api', 'as' => 'contact-list.updatte' ,'uses' => 'ContactListController@update']);
// Pega todas as listar do usuário
$router->get('/user/{id}/lists', ['middleware' => 'auth:api', 'as' => 'contact-list.get' ,'uses' => 'ContactListController@view']);

$router->get('/login/forgot', 'AuthController@forgot');

$router->post('/login/reset/{token}', ['as' => 'password.reset', 'uses' => 'AuthController@reset']);

// $router->get('/mail', function() {
//     Mail::to(['belemlc@gmail.com'])->send(new ResetPassword);

//     return new ResetPassword;
// });

